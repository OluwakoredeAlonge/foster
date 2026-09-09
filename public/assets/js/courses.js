/**
 * Fosterheirs Courses data layer.
 *
 * Public courses currently come from two sources, merged together:
 *   1. `fetchApiCourses()`: calls our own Laravel proxy (foster-heirs),
 *      which holds the partner API's bearer token server-side and
 *      strips gated content before responding. Never call the partner
 *      API directly from this file, the token must never reach the
 *      browser. Falls back to MOCK_API_COURSES if the proxy is
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
    price: "Paid",
    badge: "Bestseller",
    icon: "life-buoy",
    blurb:
      "A budget-friendly, evidence-based recovery programme built on a biopsychosocial-spiritual model: addressing the physical, psychological, social, and spiritual sides of healing.",
    link: "#",
  },
  {
    id: "fourfold-path-freedom",
    title: "The Fourfold Path to Freedom",
    category: "Addiction Recovery",
    format: "Self-paced Video Course",
    price: "Paid",
    icon: "compass",
    blurb:
      "A biological, psychological, social, and spiritual framework for lasting freedom from pornography and sexual addiction, not just temporary abstinence.",
    link: "#",
  },
  {
    id: "trauma-recovery-intensive",
    title: "Trauma Recovery Intensive",
    category: "Trauma Healing",
    format: "Coming Soon",
    price: "Paid",
    icon: "heart-handshake",
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
    price: "Paid",
    icon: "users",
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
  const price =
    typeof raw.price === "number"
      ? raw.price === 0
        ? "Free"
        : `₦${raw.price.toLocaleString()}`
      : "Paid";

  const format = raw.is_lifetime_access
    ? "Lifetime Access"
    : raw.access_duration_months
      ? `${raw.access_duration_months}-Month Access`
      : "Course";

  const badge =
    raw.discount_percentage > 0
      ? `${raw.discount_percentage}% Off`
      : raw.has_certificate
        ? "Certificate"
        : undefined;

  return {
    id: raw.slug || raw.id,
    title: raw.title,
    category: raw.category?.name || "General",
    format,
    price,
    badge,
    icon: "book-open",
    blurb: raw.details || "",
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

function courseCardHTML(course) {
  const badge = course.comingSoon
    ? `<span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Coming Soon</span>`
    : `<span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">${course.price || "Paid Course"}</span>`;

  const extraBadge = course.badge
    ? `<span class="inline-flex items-center gap-1 rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white">${course.badge}</span>`
    : "";

  const localTag =
    course.source === "local"
      ? `<span class="inline-flex items-center gap-1 rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-800">Added by Team</span>`
      : "";

  const cta = course.comingSoon
    ? `<button disabled class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 cursor-not-allowed">Notify Me</button>`
    : `<a href="${course.link || "#"}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800">
         Get Access <i data-lucide="arrow-right" class="h-4 w-4"></i>
       </a>`;

  return `
    <div class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
      <div class="flex items-center justify-between gap-2">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
          <i data-lucide="${course.icon || "book-open"}" class="h-5 w-5"></i>
        </div>
        <div class="flex flex-wrap justify-end gap-2">${extraBadge}${localTag}${badge}</div>
      </div>
      <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-emerald-700">${course.category || "General"} &middot; ${course.format || "Course"}</p>
      <h3 class="mt-1 text-lg font-bold text-slate-900">${course.title}</h3>
      <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">${course.blurb || ""}</p>
      ${cta}
    </div>
  `;
}
