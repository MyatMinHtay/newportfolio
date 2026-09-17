# 28 — Old Portfolio Analysis & Renewal Map

**Purpose:** Comprehensive audit of `oldportfolio/` and content mapping for the new Laravel Portfolio CMS.

**Related:** [01-project-overview](01-project-overview.md) · [02-architecture](02-architecture.md) · [03-database](03-database.md) · [09-roadmap](09-roadmap.md) · [10-ideas](10-ideas.md) · [21-DOCUMENTATION-STATUS](21-DOCUMENTATION-STATUS.md)

---

## Table of contents

1. [Old Portfolio Audit](#1-old-portfolio-audit)
2. [Profile & Bio Information](#2-profile--bio-information)
3. [Existing Projects Inventory](#3-existing-projects-inventory)
4. [Skills Inventory](#4-skills-inventory)
5. [Assets & Media Inventory](#5-assets--media-inventory)
6. [Renewal Requirements & Gap Analysis](#6-renewal-requirements--gap-analysis)
7. [Database Schema Mapping](#7-database-schema-mapping)
8. [Current work](#8-current-work-homepage-2026-09)

---

## 1. Old Portfolio Audit

The legacy portfolio located in `oldportfolio/` is a static HTML/CSS/JS single-page application:
- **Core file:** `oldportfolio/index.html` (~1,077 lines)
- **Styling:** Bootstrap 5.1.3 CDN, FontAwesome 6 CDN, and `css/style.css` (custom CSS with dark mode class toggle and responsive grid)
- **Scripting:** `js/app.js` (dark mode toggle, scroll reveal on `.projects`, typing animation on `#aboutparagraph`, form label animations)
- **Media:** 9 project thumbnails/images, 17 skill logos, personal profile photo (`myimg.png`), brand logo (`logo.png`)

---

## 2. Profile & Bio Information

| Field | Value in Old Portfolio | Target in New Portfolio |
|-------|------------------------|-------------------------|
| **Name** | Myat Min Htay | `settings: site_name` / `author_name` |
| **Title / Role** | Full Stack Website Developer | `settings: site_title` / `hero_title` |
| **Headline** | "Full Stack Website Developer" | Hero section heading |
| **Bio Statement** | *"I start learning about web-development since 2018. Then I Join WDF class in DataLand Technology. I Study PHP , Laravel by myself . Then I internship as a backend developer in a Small Startup Company. Then I participated in Grocery Sales POS project as a freelancer. you can look my project video on my website where I mention below. #Rising Together"* | `settings: about_bio` / About page |
| **Birthday** | 6th Dec 2001 | Personal info / About detail |
| **Location** | Mandalay, Myanmar | Personal info / About detail |
| **Education** | 2nd year in physics (YDNB) + DataLand Technology (WDF) | Experience / Education list |
| **Email** | `myatminhtay7@gmail.com` | `settings: contact_email` |
| **Phone** | `09266216485` | `settings: contact_phone` |
| **Freelance Status** | Available | Badge / settings |
| **Resume URL** | Google Drive link | `resumes` table / file upload |
| **Social Links** | Facebook (`/jerrym2mmh`), Viber (`+959266216485`), Telegram (`@myatminhtay`), Gmail | `social_links` table |

---

## 3. Existing Projects Inventory

All 9 existing projects from `oldportfolio/index.html` with their metadata:

| # | Project Title | Description / Summary | Tech / Stack | Live Demo Link | Video Embed (Vimeo) |
|---|---------------|-----------------------|--------------|----------------|---------------------|
| 1 | **AMZ Photo Studio** | Photo studio site showcasing packages and studio services | HTML, CSS, JS, Bootstrap | `https://myatminhtay.github.io/amzphotostudio/` | `660977333` |
| 2 | **Hosting Site** | Web hosting company landing page with interactive pricing & service features | HTML, CSS, Bootstrap, JS | `https://myatminhtay.github.io/hostingsite/` | `660978555` |
| 3 | **To Do List** | Interactive task management application with password-protected task deletion | JS, HTML, CSS | `https://myatminhtay.github.io/todolist/` | `660981930` |
| 4 | **Small Movie Site** | Mini movie directory featuring 4 distinct filtering categories | JS, CSS, HTML | `https://myatminhtay.github.io/smallmovie/` | `660981079` |
| 5 | **Comic and Manga** | Comic/manga reader interface offering slide mode, book mode, and carousel mode | JS, CSS, Bootstrap | `https://myatminhtay.github.io/comicandmanga/` | `660983140` |
| 6 | **Music Website** | Web audio player with track switching, playlist and auto-next functionality | JS, Audio API, Bootstrap | `https://jerrym2channel.infinityfreeapp.com` | `660979685` |
| 7 | **Vue Js Blog** | Multi-post blog application with paragraph formatting and image uploads | Vue.js, Firebase | `http://reddragon-nagani.infinityfreeapp.com/` | `712042244` |
| 8 | **Pizza Order System** | Comprehensive pizza ordering and admin management platform with mobile API | Laravel 8, Jetstream, MySQL | *(Demo offline)* | `716089981` |
| 9 | **Webtoon Website** | Webtoon management platform integrated with a coin/credit transaction system | Laravel (latest), MySQL | *(Demo offline)* | `827340947` |

---

## 4. Skills Inventory

From `oldportfolio/img/skills/`:
- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript (ES6+), jQuery, Vue.js, Angular
- **Backend:** PHP, Laravel, Node.js, Python, WordPress
- **Databases:** MySQL, MongoDB
- **Tools & Workflow:** Git, GitHub

---

## 5. Assets & Media Inventory

Located in `oldportfolio/img/`:
- `logo.png` — Personal brand logo
- `myimg.png` — Personal developer portrait
- `thumbnail1.png` to `thumbnail9.png`, `thubmnail3.png`, `thubmnail4.png`, `thubmnail5.png`, `thubmnail6.png`, `thubmnail7.png` — Project covers
- `laravel.png`, `df.png`, `3.jpg` — Supporting images
- `skills/*.png` (17 items) — Tech stack badge logos

*Migration note:* When seeding or displaying, these assets can be organized into `public/assets/img/` or stored via Laravel's `storage/app/public/` when managed via admin.

---

## 6. Renewal Requirements & Gap Analysis

The user specified:
1. **Redesign / Modernization:**
   - Do not need to copy the exact old design; upgrade to the modern Bootstrap 5 tokenized design system established in `knowledge/13-design-system.md` and `resources/views/`.
2. **Admin Panel Management:**
   - Manage Projects, Skills, Experience, Resumes, Settings, and Blog Posts from `/admin`.
3. **Case Studies & Demo Links:**
   - Each project needs rich details: Problem, Architecture/Approach, Solution, Tech Stack tags, Live Demo Link, Repo Link, Video Demo (Vimeo/YouTube embed).
   - Homepage shows current work first; per-project case study pages come later (`projects.body` already holds Markdown stubs).
4. **Scripts & Tools Sharing (Future/Additive):**
   - A dedicated section/module to share developer scripts, utility snippets, and automation tools authored by Myat Min Htay.

---

## 7. Database Schema Mapping

The existing `03-database.md` schema already accommodates the majority of these requirements:

- **`projects` table:**
  - `title`, `slug`, `summary`
  - `body` (Markdown for rich Case Study writeups)
  - `cover_image`
  - `project_url` (Live Demo)
  - `repo_url` (GitHub repository)
  - `video_url` *(Recommended addition: nullable string for Vimeo/YouTube embeds)*
  - `tech_stack` (JSON array of strings)
  - `is_featured`, `is_published`, `sort_order`
- **`skills` table:**
  - `name`, `category` (Frontend, Backend, Database, Tools), `proficiency` (1–5), `sort_order`, `is_published`
- **`experiences` table:**
  - DataLand Technology, Startup backend developer internship, Grocery Sales POS freelance project.
- **`resumes` table:**
  - Upload PDF resume file directly through admin panel.
- **`settings` table:**
  - Site name, bio, social links, contact numbers, email.
- **`developer_scripts` (Future / Roadmap addition):**
  - For sharing custom user-authored scripts, downloads, and documentation.

---

## 8. Current work (homepage, 2026-09)

Published and featured, in this order:

| # | Project | Type | Notes |
|---|---------|------|--------|
| 1 | MorningStar Translation MM | Product | Live: `https://morningstartranslationmm.com/` |
| 2 | Nexus VPN Panel | Product | Live: `https://allisfree.online/` |
| 3 | Dream Comic | Freelance | Live: `https://dreamscomicmm.com/` · AWS S3 |
| 4 | KM Explorer | Freelance | Live: `https://kmexplorer.com/` (travel platform) |
| 5 | Laravel Portfolio CMS | Product | This repository |
| 6 | Dev Toolkit | Preview | Experimental: `https://devtoolkit.freedev.app/` |

Early GitHub Pages / InfinityFree demos stay unpublished. Planned later products (not seeded): **P Finance**, **LMS** — see [10-ideas](10-ideas.md).

