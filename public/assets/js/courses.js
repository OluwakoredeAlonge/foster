/**
 * Fosterheirs Courses data layer.
 *
 * Public courses currently come from two sources, merged together:
 *   1. `fetchApiCourses()`: calls our own Laravel proxy (foster-heirs),
 *      which holds the partner API's bearer token server-side, strips
 *      gated content, and hides any course the admin has curated off
 *      the public site (see admin/external-courses). Never call the
 *      partner API directly from this file, the token must never reach
 *      the browser. Falls back to MOCK_API_COURSES if the proxy is
 *      unreachable or returns nothing.
 *   2. Local admin-created courses, stored in the browser via
 *      localStorage (see resources/views/admin.blade.php). This is a
 *      prototype persistence layer only; swap it for real backend calls
 *      once one exists.
 */

// Same-origin now that this app serves both the views and the proxy.
const COURSES_API_URL = "/api/public/courses";

const MOCK_API_COURSES = [
  {
    id: "quit-porn-sex-addiction",
    title: "Quit Porn and Sex Addiction",
    category: "Addiction Recovery",
    format: "14-Module Programme",
    price: null,
    priceLabel: "Paid",
    badge: "Bestseller",
    blurb:
      "A budget-friendly, evidence-based recovery programme built on a biopsychosocial-spiritual model: addressing the physical, psychological, social, and spiritual sides of healing.",
    link: "#",
  },
  {
    id: "fourfold-path-freedom",
    title: "The Fourfold Path to Freedom",
    category: "Addiction Recovery",
    format: "Self-paced Video Course",
    price: null,
    priceLabel: "Paid",
    blurb:
      "A biological, psychological, social, and spiritual framework for lasting freedom from pornography and sexual addiction, not just temporary abstinence.",
    link: "#",
  },
  {
    id: "trauma-recovery-intensive",
    title: "Trauma Recovery Intensive",
    category: "Trauma Healing",
    format: "Coming Soon",
    price: null,
    priceLabel: "Paid",
    comingSoon: true,
    blurb:
      "A guided journey through psycho-trauma therapy techniques for processing deep emotional wounds, led by our clinical team.",
    link: "#",
  },
  {
    id: "marriage-foundations",
    title: "Marriage Foundations",
    category: "Marriage & Relationships",
    format: "Coming Soon",
    price: null,
    priceLabel: "Paid",
    comingSoon: true,
    blurb:
      "Faith-based communication and conflict-resolution tools for couples building, or rebuilding, a resilient marriage.",
    link: "#",
  },
];

const LOCAL_COURSES_KEY = "fosterheirs_admin_courses";

function getLocalCourses() {
  try {
    const raw = localStorage.getItem(LOCAL_COURSES_KEY);
    return raw ? JSON.parse(raw) : [];
  } catch (err) {
    console.warn("Could not read local courses:", err);
    return [];
  }
}

function saveLocalCourses(list) {
  localStorage.setItem(LOCAL_COURSES_KEY, JSON.stringify(list));
}

function addLocalCourse(course) {
  const list = getLocalCourses();
  const withId = {
    ...course,
    id: course.id || `local-${Date.now()}`,
    source: "local",
  };
  list.unshift(withId);
  saveLocalCourses(list);
  return withId;
}

function updateLocalCourse(id, updates) {
  const list = getLocalCourses().map((c) =>
    c.id === id ? { ...c, ...updates } : c
  );
  saveLocalCourses(list);
}

function deleteLocalCourse(id) {
  const list = getLocalCourses().filter((c) => c.id !== id);
  saveLocalCourses(list);
}

/**
 * Maps a trimmed course record from the foster-heirs proxy into the shape
 * courseCardHTML() expects. Field names mirror
 * App\Http\Resources\CourseApiResource on the partner app (see
 * config/course_catalog.php `public_fields`). Only ever receives catalog
 * fields, the proxy strips gated week/material content before this runs.
 */
function mapPartnerCourse(raw) {
  const format = raw.is_lifetime_access
    ? "Lifetime Access"
    : raw.access_duration_months
      ? `${raw.access_duration_months}-Month Access`
      : "Course";

  return {
    id: raw.slug || raw.id,
    title: raw.title,
    category: raw.category?.name || raw.type || "General",
    format,
    image_url: raw.image_url || null,
    price: typeof raw.price === "number" ? raw.price : null,
    originalPrice: typeof raw.original_price === "number" ? raw.original_price : null,
    discountPercentage: raw.discount_percentage || 0,
    hasCertificate: !!raw.has_certificate,
    ratingAvg: raw.rating_avg || 0,
    ratingsCount: raw.ratings_count || 0,
    link: raw.purchase_url || "#",
    source: "api",
  };
}

/**
 * Calls the foster-heirs proxy (never the partner API directly). Falls
 * back to sample data if the proxy is unreachable, misconfigured, or
 * returns an empty catalog, so the public site never shows a blank grid.
 */
async function fetchApiCourses() {
  if (!COURSES_API_URL) {
    return MOCK_API_COURSES;
  }

  try {
    const res = await fetch(COURSES_API_URL, {
      headers: { Accept: "application/json" },
    });
    if (!res.ok) {
      throw new Error(`Courses proxy responded ${res.status}`);
    }
    const body = await res.json();
    const items = Array.isArray(body.data) ? body.data : [];
    return items.length ? items.map(mapPartnerCourse) : MOCK_API_COURSES;
  } catch (err) {
    console.warn("Courses proxy unavailable, showing sample courses:", err);
    return MOCK_API_COURSES;
  }
}

async function getAllCourses() {
  const [apiCourses, localCourses] = await Promise.all([
    fetchApiCourses(),
    Promise.resolve(getLocalCourses()),
  ]);
  return [...localCourses, ...apiCourses];
}

function escapeHtml(str) {
  return String(str ?? "").replace(/[&<>"']/g, (c) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#39;",
  })[c]);
}

/**
 * Compact teaser card for the homepage grid — mirrors the layout of the
 * partner site's own course card (image, badges, rating, price), but
 * deliberately never renders the full course description here. The
 * description belongs on the course's own detail page, not a preview
 * grid; showing it here used to blow the card out to the height of the
 * longest course's full write-up.
 */
function courseCardHTML(course) {
  const priceLabel =
    course.price === 0
      ? "Free"
      : typeof course.price === "number"
        ? `₦${course.price.toLocaleString()}`
        : course.priceLabel || "Paid";

  const media = course.image_url
    ? `<img src="${escapeHtml(course.image_url)}" alt="${escapeHtml(course.title)}" class="h-40 w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy" />`
    : `<div class="flex h-40 w-full items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50">
         <i data-lucide="graduation-cap" class="h-12 w-12 text-emerald-300"></i>
       </div>`;

  const discountBadge =
    course.discountPercentage > 0
      ? `<span class="absolute right-2.5 top-2.5 rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white shadow">-${course.discountPercentage}%</span>`
      : "";

  const comingSoonBadge = course.comingSoon
    ? `<span class="absolute right-2.5 top-2.5 rounded-full bg-amber-500 px-2 py-1 text-xs font-bold text-white shadow">Coming Soon</span>`
    : "";

  const teamBadge =
    course.source === "local"
      ? `<span class="inline-flex items-center gap-1 rounded bg-sky-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-sky-700">Added by Team</span>`
      : "";

  const certificateBadge = course.hasCertificate
    ? `<span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-blue-700">
         <i data-lucide="award" class="h-3 w-3"></i> Certificate
       </span>`
    : "";

  const ratingRow =
    course.ratingsCount > 0
      ? `<div class="mb-2 flex items-center gap-1 text-xs text-amber-500">
           <i data-lucide="star" class="h-3.5 w-3.5 fill-current"></i>
           <span class="font-medium text-slate-600">${course.ratingAvg.toFixed(1)}</span>
           <span class="text-slate-400">(${course.ratingsCount})</span>
         </div>`
      : "";

  const priceRow = `
    <div class="mt-auto flex items-baseline gap-2 border-t border-slate-50 pt-3">
      <span class="text-lg font-extrabold text-slate-900">${priceLabel}</span>
      ${course.originalPrice ? `<span class="text-sm text-slate-400 line-through">₦${course.originalPrice.toLocaleString()}</span>` : ""}
    </div>`;

  const cta = course.comingSoon
    ? `<button disabled class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 cursor-not-allowed">Notify Me</button>`
    : `<a href="${course.link || "#"}" target="${course.link && course.link !== "#" ? "_blank" : "_self"}" rel="noopener" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800">
         Get Access <i data-lucide="arrow-right" class="h-4 w-4"></i>
       </a>`;

  return `
    <div class="course-card group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
      <div class="relative overflow-hidden">
        ${media}
        ${discountBadge}${comingSoonBadge}
      </div>
      <div class="flex flex-1 flex-col p-5">
        <div class="mb-2 flex flex-wrap items-center gap-1.5">
          <span class="inline-flex items-center gap-1 rounded bg-emerald-50 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-emerald-700">${escapeHtml(course.category || "General")}</span>
          ${certificateBadge}${teamBadge}
        </div>
        <h3 class="mb-2 line-clamp-2 flex-1 text-base font-bold leading-snug text-slate-900 transition group-hover:text-emerald-700">${escapeHtml(course.title)}</h3>
        <p class="mb-2 text-xs font-medium text-slate-400">${escapeHtml(course.format || "Course")}</p>
        ${ratingRow}
        ${priceRow}
        ${cta}
      </div>
    </div>
  `;
}
