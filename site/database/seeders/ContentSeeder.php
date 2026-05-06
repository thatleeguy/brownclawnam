<?php

namespace Database\Seeders;

use App\Models\Capability;
use App\Models\CaseStudy;
use App\Models\Insight;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------- CAPABILITIES ----------------
        $this->capability(
            code: 'CAP / 01',
            eyebrow: 'Reliability',
            title: 'Reliability Engineering',
            order: 10,
            summary: 'Identify and eliminate root causes of equipment failure through structured analysis. We work the failure modes that are actually costing you the most — usually the ones nobody has time to look at.',
            methods: ['RCFA', 'FMEA', 'Weibull', 'Bad-actor analysis', 'PdM strategy', 'Reliability-block'],
            deliverables: ['RCFA report', 'FMEA register', 'Bad-actor list', 'PdM plan'],
            body: <<<MD
## What this is

Reliability engineering is the structured practice of identifying *why* equipment fails and intervening upstream of the failure. It's not condition monitoring. It's not scheduled maintenance. It's the work of taking a recurring failure mode, instrumenting it back to its root cause, and redesigning the asset, the procedure, or the operating context so the failure stops recurring.

Most operations have a small number of bad actors that absorb a disproportionate share of the maintenance budget. A reliability engineer's job is to find them, make the case for fixing them, and lead the fix.

## How we run a reliability engagement

We start with **data triage**. Most CMMS extracts contain enough signal to identify the top ten bad actors within a week, even when the failure-mode codes are unreliable. We rank by recurring downtime, MTBF deterioration, work-order count, and cost — then walk the list with operations and maintenance leadership to confirm.

From there we run a **structured RCFA** on the top three to five — usually the ones that map to safety or production-loss exposure. RCFA is a discipline, not a meeting; we use a documented method (PROACT, Apollo, or 5-Whys with a fault-tree depending on the failure type) and we hold the analysis open until the physical, human, and latent root causes are all named.

The output is a **fix plan**: design changes, procedure changes, training, spares strategy, and operator behaviours, ranked by ROI. We help you build the business case to fund it. Then we stay in the field while it gets implemented and measure the result.

## What you get

- A defensible bad-actor list scored against your risk matrix
- One to five completed RCFAs with documented physical, human, and latent root causes
- A failure-mode register that traces forward into your maintenance tactics
- A predictive maintenance plan keyed to the failure modes (not to vendor recommendations)
- Operator and maintenance training in-place, not in a classroom

## What we don't do

- We don't sell software or hardware. We are vendor-neutral by design.
- We don't run the program forever. Every engagement has a written hand-off plan.
- We don't generate paper. If a deliverable doesn't change behaviour on the floor, we don't produce it.
MD,
        );

        $this->capability(
            code: 'CAP / 02',
            eyebrow: 'Strategy',
            title: 'Asset Strategy Development',
            order: 20,
            summary: 'Build maintenance strategies that match the asset, the operating context, and the business case. Move from calendar-based PMs to condition-based, criticality-weighted programs that survive turnover.',
            methods: ['RCM2', 'Criticality analysis', 'PM optimization', 'Spares strategy', 'Tactic library'],
            deliverables: ['Criticality matrix', 'Tactic library', 'PM job plans', 'Spares spec'],
            body: <<<MD
## What this is

Asset strategy is the connective tissue between *what an asset is supposed to do* and *what your team does to keep it doing that*. Most operations inherit their strategy from the EPCM at construction and never revisit it. The result is a calendar-based PM program full of vendor recommendations that don't match how the asset is actually used.

We rebuild the strategy from the failure modes up.

## How we run a strategy engagement

We start with the **asset hierarchy** — almost always the first thing we have to fix. Most hierarchies are nameplate-deep when they need to be functional. A primary crusher is not one asset; it is a set of functions (feed, crush, discharge, lubrication, dust suppression, structural support) and each function fails in a small number of identifiable ways.

Once the hierarchy is right, we run **criticality** against your risk matrix — not a generic one. The output is a register that ranks every asset by consequence (safety, environment, production loss, repair cost) and probability (failure history, age, duty cycle).

Then we build the **tactic library**. For each critical and high-criticality function, we trace the failure modes and write a maintenance tactic that addresses each. The tactic is keyed to the failure mode, not to the calendar. PM intervals are derived from MTBF or condition, not from the OEM manual.

Finally, the **spares strategy** is reviewed against the new criticality call. Over-stocking on B and C-criticality assets is one of the most common findings; under-stocking on A-criticality is the other.

## What you get

- A reset asset hierarchy at functional level
- A criticality register, signed by your operations and maintenance leadership
- A tactic library keyed to failure modes — usable in your CMMS
- A revised PM program with intervals derived from data, not defaults
- A spares strategy review with a recommended re-stocking plan
MD,
        );

        $this->capability(
            code: 'CAP / 03',
            eyebrow: 'Assessment',
            title: 'Maintenance & Reliability Assessments',
            order: 30,
            summary: 'A structured benchmark of where your program stands today against industry practice — and a defensible roadmap to where it needs to go. Useful for new GMs, due diligence, and program relaunches.',
            methods: ['SMRP pillars', 'UPTIME elements', 'Maturity scoring', 'KPI baseline'],
            deliverables: ['Maturity score', 'Gap roadmap', 'KPI dashboard', 'Investment case'],
            body: <<<MD
## What this is

A maintenance and reliability assessment is a structured snapshot of how your program is performing today, scored against established industry frameworks (SMRP body of knowledge and the UPTIME elements), with a defensible roadmap to where it needs to go.

It is the right tool when:

- A new General Manager or Maintenance Manager is taking over and wants an independent baseline
- Due diligence is required ahead of an acquisition or financing event
- A previous improvement program has stalled and you need to know why
- A site is approaching nameplate but maintenance cost is climbing faster than throughput

## How we run an assessment

Two weeks on-site, typically. We interview from the General Manager down to the journeyman and the planner. We pull a CMMS extract and run it against a standard set of reliability KPIs (PM compliance, schedule compliance, planned-to-corrective ratio, MTBF on critical assets, rework rate). We walk the floor.

Then we score against the SMRP and UPTIME frameworks across business and management, asset reliability, work management, leadership, and equipment for reliability — with evidence cited for each score.

The deliverable is a single document: where you are, where industry leaders are, where you need to be, and a sequenced roadmap to get there with effort and investment estimates.

## What you get

- An independent maturity score across the SMRP and UPTIME pillars
- A KPI baseline drawn directly from your CMMS, not a survey
- A gap analysis with evidence — not "consultant feel"
- A sequenced roadmap with phases, effort, and investment estimates
- An investment case suitable for capital approval
MD,
        );

        // ---------------- CASE STUDIES ----------------
        $this->case(
            code: 'WORK / 047',
            title: 'Restoring uptime at a 12 Mt/a metallurgical coal preparation plant.',
            featured: true,
            order: 10,
            sector: 'metallurgical_coal',
            sectorLabel: 'Coal preparation plant',
            region: 'Western Canada',
            clientDisplay: 'Tier-1 metallurgical coal operator',
            engagementMonths: 9,
            year: 2025,
            summary: 'A site running on a calendar-based PM program inherited from construction. Bad-actors going unidentified for years. We rebuilt the asset hierarchy, ran criticality across 1,800 tags, and rewrote the tactic library against actual failure modes.',
            kpiStats: [
                ['value' => '−62',  'unit' => '%',  'label' => 'Downtime ▼',     'note' => 'From 14.8% → 5.6% on the prep plant.'],
                ['value' => '$3.8', 'unit' => 'M',  'label' => 'Annual savings', 'note' => 'Recurring, on PM program rationalisation.'],
                ['value' => '9',    'unit' => 'mo', 'label' => 'Engagement',     'note' => 'Three documented phases.'],
            ],
            body: <<<MD
## The brief

The site was a 12 Mt/a metallurgical coal preparation plant operating four years past commissioning. The PM program had been delivered at construction by the EPCM and never substantively revised. The maintenance organization was spending 71% of its time on reactive and corrective work; the planned-to-corrective ratio sat at 0.41 against a leading-practice benchmark of 4-to-1.

The Maintenance Superintendent had identified four recurring failure modes that were absorbing roughly \$4M per year in unplanned downtime, but no one had the time to run a structured analysis against any of them.

## What we did

### Phase 1 — Establish baseline (weeks 1–4)

We pulled an 18-month CMMS extract and ran it against a standard reliability KPI set: PM compliance, schedule compliance, MTBF on critical assets, planned-to-corrective ratio, rework rate. We walked the plant with operations, maintenance, and engineering. We identified ten bad actors that absorbed 68% of the unplanned downtime hours.

The first finding was that the failure-mode codes in the CMMS were unreliable — a known problem at most sites. We worked with the planners to develop a workable subset of codes and a coding policy that maintenance could actually follow.

### Phase 2 — Asset hierarchy + criticality (weeks 5–14)

We rebuilt the asset hierarchy at the functional level. The original hierarchy had 1,250 nameplate-deep tags. The new hierarchy had 1,800 functional tags, ranked across consequence (safety, environment, production loss, repair cost) and probability (failure history, age, duty cycle) against the operator's risk matrix.

We ran criticality with a cross-functional team that included operations, maintenance, planning, and engineering — not as a desk exercise. The register was signed by the Maintenance Manager and the Operations Manager.

### Phase 3 — Tactic library + pilot (weeks 15–32)

For each high and critical asset, we traced the failure modes and rewrote the maintenance tactic against the failure mode. PM intervals derived from MTBF where data was available, from condition where instrumentation existed, and from a defensible engineering judgment elsewhere.

We piloted the new tactic library on the dense-medium circuit and the froth flotation cells, then expanded across the plant in three waves. Maintenance training happened on the floor during PM execution, not in a classroom.

## The outcome

After nine months, unplanned downtime was 5.6% — down from 14.8%. Planned-to-corrective ratio reached 2.1 (up from 0.41), short of the 4-to-1 benchmark but on a sustained upward trajectory. Top-three bad actors were retired; bad actor 4 (a slurry pump on the froth feed) was on a documented redesign plan.

Annualised savings on PM program rationalisation alone — work-orders retired or re-scoped — were tracked at \$3.8M.

The site has run the program without us for fourteen months at this point.
MD,
        );

        $this->case(
            code: 'WORK / 042',
            title: 'Reframing the criticality matrix on a Tier-1 fleet program.',
            featured: false,
            order: 20,
            sector: 'diamond',
            sectorLabel: 'Open-pit diamond mine',
            region: 'NWT',
            clientDisplay: 'Sub-arctic diamond operator',
            engagementMonths: 6,
            year: 2025,
            summary: 'A diamond mine fleet program scored against a generic risk matrix produced criticality results that did not match how the equipment was actually used. We re-ran the matrix against the operator\'s own risk tolerance and produced a register the maintenance and operations teams could agree on.',
            kpiStats: [
                ['value' => '38',   'unit' => '%',  'label' => 'PM rationalised', 'note' => 'Work orders retired or re-scoped.'],
                ['value' => '$4.2', 'unit' => 'M',  'label' => 'Annual savings',  'note' => 'On PM program alone.'],
                ['value' => '6',    'unit' => 'mo', 'label' => 'Engagement',      'note' => 'Two phases, on-site.'],
            ],
            body: <<<MD
## The brief

The site had completed a criticality assessment two years prior using a generic mining-industry risk matrix. The output didn't match how the maintenance and operations teams actually thought about the assets — for example, the matrix scored production-loss risk on a one-week mean-time-to-repair assumption that didn't reflect the site's spares strategy or the climate-driven repair-window constraints.

The result was a critical-asset register that the Maintenance Manager could not defend in front of his General Manager.

## What we did

We re-ran the criticality assessment against the operator's own risk matrix — calibrated against the real consequence of a one-week production loss at this site, the real safety exposure profile (cold-weather operations, isolated work), and the real environmental footprint considerations.

The output was a re-prioritised register that retired 38% of the existing PM workload (the result of over-classification on B and C-criticality fleet assets) and added depth on a small number of A-criticality assets (the haul-truck strut program and the conveyor drive trains, both of which had been scored too low).

The re-prioritised register was signed by the Maintenance Manager and the GM, and has held through one budget cycle.
MD,
        );

        $this->case(
            code: 'WORK / 038',
            title: 'A six-week RCFA blitz on the SAG mill drive train.',
            featured: false,
            order: 30,
            sector: 'copper',
            sectorLabel: 'Copper concentrator',
            region: 'BC',
            clientDisplay: 'Mid-tier copper concentrator',
            engagementMonths: 2,
            year: 2025,
            summary: 'A SAG mill drive train averaging four unplanned shutdowns per quarter for three years. A six-week structured RCFA traced the root cause to a coupling alignment procedure that had been written for the original drive — and never revised after a 2019 motor change.',
            kpiStats: [
                ['value' => '8.5', 'unit' => '×',   'label' => 'MTBF improvement', 'note' => 'On the drive train post-fix.'],
                ['value' => '4',   'unit' => '→1', 'label' => 'Shutdowns / qtr',   'note' => 'Sustained 12-month observation.'],
                ['value' => '6',   'unit' => 'wk',  'label' => 'Engagement',       'note' => 'On-site blitz.'],
            ],
            body: <<<MD
## The brief

A copper concentrator's primary SAG mill drive train had averaged four unplanned shutdowns per quarter for three consecutive years. The site had run two prior root-cause investigations, both of which had concluded "operator error" or "manufacturing defect" without changing the failure rate.

The Reliability Engineer asked us to lead a structured RCFA over six weeks before the next planned shutdown.

## What we did

We assembled a cross-functional team and ran a structured RCFA using a fault-tree method. The investigation traced through six layers of contributing cause down to a coupling alignment procedure that had been authored for the original drive motor specification at construction.

The drive motor had been replaced in 2019. The replacement motor had a slightly different shaft tolerance profile, but the alignment procedure had never been revised. As a result, every alignment job since 2019 had been performed against a tolerance band that the new motor could not consistently meet — even with skilled millwrights doing the work correctly to the existing procedure.

The fix was a procedure rewrite, two days of millwright training on the new tolerances, and an alignment record-keeping change.

## The outcome

Twelve months after the fix, the drive train had recorded one unplanned shutdown — a one-time gear-tooth event unrelated to alignment. MTBF on the drive train improved 8.5× over the prior three-year baseline.

The investigation also surfaced four other procedures that had been written against original equipment specifications and never revised after equipment changes. Those have been added to the site's procedure-review backlog.
MD,
        );

        $this->case(
            code: 'WORK / 029',
            title: 'Designing a tactic library a relief operator can actually use.',
            featured: false,
            order: 40,
            sector: 'zinc',
            sectorLabel: 'Zinc smelter',
            region: 'MB',
            clientDisplay: 'Mid-tier zinc smelting facility',
            engagementMonths: 4,
            year: 2024,
            summary: 'A zinc smelter\'s PM tactic library was technically defensible but practically unusable — relief operators on backshift were skipping steps because the procedures assumed knowledge they didn\'t have. We rewrote the library against an actual relief-operator standard, and tracked compliance.',
            kpiStats: [
                ['value' => '94.7', 'unit' => '%',   'label' => 'PM compliance ▲', 'note' => 'From 67% baseline at engagement start.'],
                ['value' => '0',    'unit' => 'min', 'label' => 'Lost on retrain', 'note' => 'Procedures usable as-written.'],
                ['value' => '4',    'unit' => 'mo',  'label' => 'Engagement',     'note' => 'On-site, two phases.'],
            ],
            body: <<<MD
## The brief

The smelter had spent two years building a tactic library against a SMRP-aligned standard. On paper, the library was a model of reliability practice. In execution, PM compliance was sitting at 67% and the Maintenance Superintendent had identified that backshift relief operators were the consistent compliance gap.

The procedures assumed that the operator running them had three years of experience on this specific plant. Most of the relief operators didn't.

## What we did

We worked with two relief operators and a journeyman to rewrite the top-30 PM procedures against an actual relief-operator skill profile. The rewrites added context (why this step, what failure mode it addresses), expected condition descriptions (what nominal looks like, what abnormal looks like), and explicit hand-off notes for each step that depended on prior context.

We then rolled the new procedures across the plant in two phases over four months, with relief operators leading the floor training rather than journeymen.

## The outcome

PM compliance at the end of the engagement was 94.7%, sustained for eight months at this point. The Maintenance Superintendent reported zero re-training time required when the procedures were used by relief crews who hadn't previously seen them — the procedures were now self-contained.
MD,
        );

        // ---------------- INSIGHTS ----------------
        $this->insight(
            code: 'BRIEF / 014',
            kicker: 'Reliability',
            title: 'Why your CMMS data is lying to you — and what to do about it.',
            isLead: true,
            readingMinutes: 8,
            publishedDaysAgo: 12,
            excerpt: 'Most failure-mode codes were filled in at 03:00 by someone who needed to close a work order and go home. If you\'re using that data to build a strategy, you\'re building it on fiction. A practical guide to cleaning up before you optimize — without a six-figure software bill.',
            body: <<<MD
Most reliability programs start with a CMMS data extract. Most of those data extracts are wrong.

Not maliciously wrong. Not even mostly wrong. But wrong in the specific places where it matters: failure-mode codes, downtime causes, time-to-repair, and the boundary between corrective and reactive work. If you build a strategy on top of that data without doing the cleanup work first, you will optimise toward fictional failure modes and away from the real ones.

## How the data goes wrong

The single largest source of bad data in a CMMS is the failure-mode field on the close-out screen. At most operations, this field is required to close a work order. At most operations, the menu of choices is too long, the codes are not intuitive, and the closing technician is at the end of a twelve-hour shift trying to get home.

The result is that "BRG-FAIL" or whatever the first option in the dropdown happens to be becomes the answer to almost everything that fails. The data shows hundreds of bearing failures per year on assets that haven't had a bearing fail in a decade.

The second-largest source is the line between *corrective* and *reactive* — between work that was scheduled and executed against a known failure mode and work that was emergency. The boundary is a planning concept, not a maintenance concept, and most CMMSes don't enforce it cleanly. You see corrective work that was actually emergency, emergency work that was actually planned-but-late, and planned work that got rolled up into corrective because nobody changed the type after the priority shifted.

## What to do about it

The naive answer is: clean up the historic data. Don't. The historic data is what it is, and trying to reclassify three years of work orders is a six-month project that will not produce a usable register.

The pragmatic answer is two-part:

**1. Build a small, defensible coding subset for the future.**

Take your existing failure-mode dictionary and ruthlessly pare it down. For each asset class, you should be able to write a one-page list of failure modes that covers 90% of what's actually happening. Train the closing technicians once. Audit the codes weekly for two months. The data after the change date is now usable.

**2. Use the historic data for triage only — and validate everything by walking the plant.**

Pull the historic data and use it to identify the bad actors by *cost* and *frequency* — both of which are robust to coding errors. Then walk the plant with operations and maintenance and ask the obvious question: "is this what's actually happening?" The answer will surface most of the disagreements before you spend any time on detailed analysis.

In ninety days you have a usable forward-looking dataset and a triaged bad-actor list. That is enough to start.

## What not to do

Do not buy software to fix the data quality problem. The software does not know what your codes mean, and the software does not have a relationship with your closing technicians. The data quality problem is a discipline problem, not a technology problem.

Do not run a reliability strategy off bad data and hope to fix the data later. You will optimise the wrong things and lose credibility with operations leadership when the predictions don't hold.

Do not pretend the data is fine because no one wants to admit it isn't. Data quality is a normal, almost universal problem in maintenance organisations. Naming it is half the fix.
MD,
        );

        $this->insight(
            code: 'BRIEF / 013',
            kicker: 'Method',
            title: 'The criticality assessment trap.',
            isLead: false,
            readingMinutes: 6,
            publishedDaysAgo: 23,
            excerpt: 'Ranking equipment is the easy part. Acting on the ranking is the hard part. Three failure modes of failure-mode programs.',
            body: <<<MD
Criticality assessments are a useful tool. They are also one of the most reliable ways to spend three months producing a document that does not change anything on the floor.

The pattern is consistent: a cross-functional team meets for ten weeks, scores every asset against a generic risk matrix, produces a critical-asset register, and then the register goes into a SharePoint folder where it stays. The maintenance program does not change. The PM intervals do not change. The spares strategy does not change.

Three reasons this happens, and three things that fix it.

## Failure mode 1: scoring against a matrix nobody owns

If the risk matrix you use was downloaded from an industry guide and never approved by the General Manager and the Maintenance Manager, the criticality scores it produces will not survive the first cost-cutting cycle. The matrix has to belong to the operator — the consequence and probability bands have to reflect what *this* site actually treats as a high consequence event. Otherwise, the criticality numbers are scoring a generic mine and not your mine.

Fix: get the matrix signed by operations and maintenance leadership *before* the scoring starts. Spend two days getting the bands right.

## Failure mode 2: scoring at the wrong asset level

If the asset hierarchy is nameplate-deep — meaning a pump and its motor are scored as one asset, or a primary crusher is scored as one asset rather than as a set of functions — the criticality score will not be actionable. You can't write a tactic against "primary crusher" because the crusher fails in a dozen different ways with a dozen different consequences.

Fix: rebuild the hierarchy at the functional level *before* the criticality scoring. This is more work than people expect.

## Failure mode 3: stopping at the register

Most criticality engagements end with a signed register. Almost none of them include the three downstream artefacts that make the register actionable: a revised PM program, a revised spares strategy, and a revised criticality-driven KPI set.

Fix: scope the engagement to include all three. If your scope ends at the signed register, you have not finished the job.
MD,
        );

        $this->insight(
            code: 'BRIEF / 012',
            kicker: 'Field',
            title: 'From reactive to proactive: a 90-day blueprint for mid-tier operations.',
            isLead: false,
            readingMinutes: 11,
            publishedDaysAgo: 35,
            excerpt: 'What to actually do in week 1, week 4, week 8 and week 12 if you\'ve been told to "fix maintenance" without a budget for fancy software.',
            body: <<<MD
You have been handed the maintenance program and told to make it better. The site is mid-tier — 200 to 400 hourly, two to four critical lines, a CMMS that everyone complains about, no reliability engineer, and no software budget. Here is what the first ninety days should look like.

## Week 1 — Pull the data and walk the plant

Start with the work-order extract for the last twelve months. You don't need the data to be clean — you need it for triage. Rank by total downtime hours per asset and by total maintenance cost per asset. The top ten on each list will overlap by 60–80%. That overlap is your bad-actor list.

Walk the plant with operations and maintenance leadership in the same week. Read out the bad-actor list and ask: "is this what's actually happening on the floor?" The answer will tell you which of your bad actors are real and which are coding artefacts.

## Week 4 — Lock the failure-mode coding

By week four, you should have a written, one-page coding policy for failure-mode and downtime-cause fields, with the dictionary pared down to a usable subset for each asset class. Train the closing technicians once. Audit the codes weekly for the next two months.

This is the single highest-leverage thing you can do in the first ninety days, because every reliability decision downstream depends on the data being trustable from this point forward.

## Week 8 — Run the first RCFA

Pick one bad actor — not the worst one. Pick the one where the failure mode is most likely to be physical and well-bounded (a recurring bearing, a recurring seal, a recurring electrical fault). Run a structured RCFA. Use a documented method. Document the physical, human, and latent root causes.

Pick this engagement carefully. The first RCFA is a credibility-builder. If it produces a defensible fix that operations can see, you have permission to do more. If it stalls at "operator error" or "manufacturer defect", you have lost a quarter.

## Week 12 — Show the curve

By week 12 you should have:

- A bad-actor list ranked by cost and downtime
- A coding policy that's been in place for two months
- One completed RCFA with a documented fix
- A KPI baseline: PM compliance, schedule compliance, planned-to-corrective ratio, MTBF on the top-ten bad actors

Present the curve. Present what's changed. Present what the next ninety days are going to deliver. Reliability programs at mid-tier operations live or die on whether leadership can see the curve.
MD,
        );
    }

    private function capability(string $code, string $eyebrow, string $title, int $order, string $summary, array $methods, array $deliverables, string $body): void
    {
        Capability::updateOrCreate(
            ['title' => $title],
            [
                'code'          => $code,
                'eyebrow'       => $eyebrow,
                'summary'       => $summary,
                'body'          => $body,
                'methods'       => $methods,
                'deliverables'  => $deliverables,
                'display_order' => $order,
                'published_at'  => now()->subDays(30),
            ]
        );
    }

    private function case(string $code, string $title, bool $featured, int $order, string $sector, string $sectorLabel, string $region, string $clientDisplay, int $engagementMonths, int $year, string $summary, array $kpiStats, string $body): void
    {
        CaseStudy::updateOrCreate(
            ['title' => $title],
            [
                'code'              => $code,
                'sector'            => $sector,
                'sector_label'      => $sectorLabel,
                'region'            => $region,
                'client_display'    => $clientDisplay,
                'summary'           => $summary,
                'body'              => $body,
                'kpi_stats'         => $kpiStats,
                'engagement_months' => $engagementMonths,
                'year'              => $year,
                'is_featured'       => $featured,
                'display_order'     => $order,
                'published_at'      => now()->subDays(30 + $order),
            ]
        );
    }

    private function insight(string $code, string $kicker, string $title, bool $isLead, int $readingMinutes, int $publishedDaysAgo, string $excerpt, string $body): void
    {
        Insight::updateOrCreate(
            ['title' => $title],
            [
                'code'            => $code,
                'kicker'          => $kicker,
                'excerpt'         => $excerpt,
                'body'            => $body,
                'reading_minutes' => $readingMinutes,
                'is_lead'         => $isLead,
                'published_at'    => now()->subDays($publishedDaysAgo),
            ]
        );
    }
}
