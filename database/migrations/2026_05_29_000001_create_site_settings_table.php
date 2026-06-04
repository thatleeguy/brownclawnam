<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Brand
            $table->string('brand_name')->nullable();
            $table->string('brand_tagline')->nullable();

            // SEO defaults
            $table->string('default_meta_title')->nullable();
            $table->text('default_meta_description')->nullable();

            // Theme — colours (hex). Blank = use the design default in app.css.
            $table->string('color_amber')->nullable();
            $table->string('color_amber_2')->nullable();
            $table->string('color_steel_1')->nullable();   // page canvas
            $table->string('color_steel_2')->nullable();   // surface
            $table->string('color_steel_3')->nullable();   // card
            $table->string('color_text')->nullable();
            $table->string('color_text_2')->nullable();
            $table->string('color_hazard')->nullable();

            // Theme — typography
            $table->unsignedSmallInteger('font_base_size')->nullable();   // px, body text
            $table->string('heading_scale')->nullable();                  // multiplier, e.g. 1.0

            // Navigation
            $table->json('nav_items')->nullable();          // [{number,label,url,visible}]
            $table->string('nav_cta_label')->nullable();
            $table->string('nav_cta_url')->nullable();

            // Footer
            $table->json('footer_lines')->nullable();        // [{text}]

            // Status bar
            $table->boolean('statusbar_visible')->default(true);
            $table->string('statusbar_status_label')->nullable();
            $table->string('statusbar_status_value')->nullable();
            $table->string('statusbar_location')->nullable();
            $table->string('statusbar_availability')->nullable();
            $table->string('statusbar_creds')->nullable();

            // Contact CTA band (partials/contact-cta)
            $table->boolean('cta_visible')->default(true);
            $table->string('cta_eyebrow')->nullable();
            $table->text('cta_headline_html')->nullable();
            $table->text('cta_lede')->nullable();
            $table->string('cta_button_label')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_email_note')->nullable();
            $table->string('contact_phone_display')->nullable();
            $table->string('contact_phone_url')->nullable();
            $table->string('contact_phone_note')->nullable();
            $table->string('contact_location')->nullable();
            $table->string('contact_location_note')->nullable();

            // Principal block (partials/principal)
            $table->boolean('principal_visible')->default(true);
            $table->string('principal_file_label')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_title')->nullable();
            $table->string('principal_creds')->nullable();      // free text, <br/> allowed
            $table->string('principal_photo')->nullable();      // asset path
            $table->string('principal_eyebrow')->nullable();
            $table->text('principal_headline_html')->nullable();
            $table->text('principal_bio_html')->nullable();
            $table->text('principal_quote')->nullable();
            $table->string('principal_quote_sign')->nullable();
            $table->json('principal_cv')->nullable();           // [{label,value}]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
