<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('group_name');
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            $table->unique(['language_id', 'group_name', 'key']);
        });

        $languageId = DB::table('languages')->where('code', 'en')->value('id');

        $translations = [
            // layout
            ['group_name' => 'layout', 'key' => 'nav.home', 'value' => 'Home'],
            ['group_name' => 'layout', 'key' => 'nav.what_is_private_label', 'value' => 'What is private label?'],
            ['group_name' => 'layout', 'key' => 'nav.our_mission', 'value' => 'Our mission'],
            ['group_name' => 'layout', 'key' => 'footer.tagline', 'value' => 'IsItPrivateLabel.org — Helping consumers identify private-labeled products.'],
            ['group_name' => 'layout', 'key' => 'footer.disclaimer', 'value' => 'All ratings are based on publicly available evidence. Scores 1–9 indicate suspicion levels and are not definitive claims.'],

            // home
            ['group_name' => 'home', 'key' => 'title', 'value' => 'Is It Private Label?'],
            ['group_name' => 'home', 'key' => 'subtitle', 'value' => 'Search for a company, product, or serial number to check if it might be a private-labeled product.'],
            ['group_name' => 'home', 'key' => 'search_label', 'value' => 'Search'],
            ['group_name' => 'home', 'key' => 'search_placeholder', 'value' => 'Company name, product, or serial number...'],
            ['group_name' => 'home', 'key' => 'try_label', 'value' => 'Try:'],
            ['group_name' => 'home', 'key' => 'found_results', 'value' => 'Found :count results'],
            ['group_name' => 'home', 'key' => 'no_results', 'value' => 'No results found for ":query"'],

            // product
            ['group_name' => 'product', 'key' => 'back_to_results', 'value' => '← Back to results'],
            ['group_name' => 'product', 'key' => 'by', 'value' => 'by'],
            ['group_name' => 'product', 'key' => 'serial_prefix', 'value' => 'Serial:'],
            ['group_name' => 'product', 'key' => 'suspicion_score', 'value' => 'Private Label Suspicion Score'],
            ['group_name' => 'product', 'key' => 'external_links', 'value' => 'External Links'],
            ['group_name' => 'product', 'key' => 'company_chip', 'value' => 'Company'],
            ['group_name' => 'product', 'key' => 'view_on_company_website', 'value' => 'View on company website'],
            ['group_name' => 'product', 'key' => 'evidence_and_proofs', 'value' => 'Evidence & Proofs'],
            ['group_name' => 'product', 'key' => 'download_file', 'value' => 'Download file'],
            ['group_name' => 'product', 'key' => 'view_all_products', 'value' => 'View all products from :name →'],

            // company
            ['group_name' => 'company', 'key' => 'back', 'value' => '← Back'],
            ['group_name' => 'company', 'key' => 'average_suspicion_score', 'value' => 'Average Suspicion Score'],
            ['group_name' => 'company', 'key' => 'based_on_products', 'value' => 'Based on :count product|Based on :count products'],
            ['group_name' => 'company', 'key' => 'products', 'value' => 'Products'],
            ['group_name' => 'company', 'key' => 'no_products_match_filters', 'value' => 'No products match the current filters.'],

            // what_is_private_label
            ['group_name' => 'what_is_private_label', 'key' => 'title_prefix', 'value' => 'What is'],
            ['group_name' => 'what_is_private_label', 'key' => 'title_highlight', 'value' => 'Private Label'],
            ['group_name' => 'what_is_private_label', 'key' => 'definition', 'value' => 'Private label products are manufactured by one company and sold under another company\'s brand name. Also known as store brands or generic brands, these products are designed to look like they come from a unique or independent manufacturer, but are actually produced by a third-party supplier.'],
            ['group_name' => 'what_is_private_label', 'key' => 'how_it_works_title', 'value' => 'How It Works'],
            ['group_name' => 'what_is_private_label', 'key' => 'how_it_works', 'value' => 'A retailer or distributor contracts with a manufacturer to produce goods according to their specifications. The manufacturer then packages and labels the product under the buyer\'s brand. This allows companies to offer products that appear exclusive to their store or brand, often at lower prices than name-brand alternatives.'],
            ['group_name' => 'what_is_private_label', 'key' => 'why_it_matters_title', 'value' => 'Why It Matters'],
            ['group_name' => 'what_is_private_label', 'key' => 'why_it_matters', 'value' => 'Private labeling is widespread across industries — from electronics and supplements to cosmetics and food products. While not inherently bad, the practice can be misleading when consumers believe they are buying from an independent brand when the same product is sold by many companies under different names.'],
            ['group_name' => 'what_is_private_label', 'key' => 'conclusion', 'value' => 'Understanding which products are private-labeled helps consumers make more informed purchasing decisions and identify when they are paying a premium for branding rather than quality or uniqueness.'],

            // our_mission
            ['group_name' => 'our_mission', 'key' => 'title_prefix', 'value' => 'Our'],
            ['group_name' => 'our_mission', 'key' => 'title_highlight', 'value' => 'Mission'],
            ['group_name' => 'our_mission', 'key' => 'statement', 'value' => 'IsItPrivateLabel.org exists to bring transparency to the marketplace. We believe consumers deserve to know when a product they are considering is not what it appears to be.'],
            ['group_name' => 'our_mission', 'key' => 'what_we_do_title', 'value' => 'What We Do'],
            ['group_name' => 'our_mission', 'key' => 'what_we_do', 'value' => 'We research and catalog products that are suspected of being private-labeled — items manufactured by one company and sold under another\'s brand. By collecting publicly available evidence, we assign a suspicion score to help you gauge how likely a product is to be a relabeled generic.'],
            ['group_name' => 'our_mission', 'key' => 'how_we_score_title', 'value' => 'How We Score'],
            ['group_name' => 'our_mission', 'key' => 'how_we_score', 'value' => 'Our ratings range from 1 to 9, where higher scores indicate stronger evidence that a product is private-labeled. These scores are based on publicly available information such as manufacturer listings, packaging similarities, and supply chain data.'],
            ['group_name' => 'our_mission', 'key' => 'our_principles_title', 'value' => 'Our Principles'],
            ['group_name' => 'our_mission', 'key' => 'transparency', 'value' => 'Transparency: All our evidence is publicly sourced and traceable. The code is open source, and the data are open.'],
            ['group_name' => 'our_mission', 'key' => 'fairness', 'value' => 'Fairness: We are not against private-label products. This website aims to warn customers before buying potentially misleading products. Every company can make a claim on the product page if the product is badly noted.'],
            ['group_name' => 'our_mission', 'key' => 'accuracy', 'value' => 'Accuracy: Our scores reflect evidence levels, not definitive claims.'],

            // filter_sort
            ['group_name' => 'filter_sort', 'key' => 'sort_by', 'value' => 'Sort by'],
            ['group_name' => 'filter_sort', 'key' => 'rating_high_to_low', 'value' => 'Rating (high to low)'],
            ['group_name' => 'filter_sort', 'key' => 'rating_low_to_high', 'value' => 'Rating (low to high)'],
            ['group_name' => 'filter_sort', 'key' => 'name_a_to_z', 'value' => 'Name (A-Z)'],
            ['group_name' => 'filter_sort', 'key' => 'name_z_to_a', 'value' => 'Name (Z-A)'],
            ['group_name' => 'filter_sort', 'key' => 'min_rating', 'value' => 'Min rating: :value/10'],

            // product_card
            ['group_name' => 'product_card', 'key' => 'serial_prefix', 'value' => 'SN:'],

            // proof_item
            ['group_name' => 'proof_item', 'key' => 'proof_image_alt', 'value' => 'Proof image'],
            ['group_name' => 'proof_item', 'key' => 'download_file', 'value' => 'Download file'],

            // rating
            ['group_name' => 'rating', 'key' => 'verified_non_private_label', 'value' => 'Verified non private label'],
            ['group_name' => 'rating', 'key' => 'very_unlikely_private_label', 'value' => 'Very unlikely private label'],
            ['group_name' => 'rating', 'key' => 'unlikely_private_label', 'value' => 'Unlikely private label'],
            ['group_name' => 'rating', 'key' => 'suspicious', 'value' => 'Suspicious'],
            ['group_name' => 'rating', 'key' => 'likely_private_label', 'value' => 'Likely private label'],
            ['group_name' => 'rating', 'key' => 'very_likely_private_label', 'value' => 'Very likely private label'],
            ['group_name' => 'rating', 'key' => 'confirmed_private_label', 'value' => 'Confirmed private label'],
            ['group_name' => 'rating', 'key' => 'platform_aliexpress', 'value' => 'AliExpress'],
            ['group_name' => 'rating', 'key' => 'platform_made_in_china', 'value' => 'Made-in-China'],
            ['group_name' => 'rating', 'key' => 'platform_alibaba', 'value' => 'Alibaba'],
            ['group_name' => 'rating', 'key' => 'platform_company', 'value' => 'Company'],
            ['group_name' => 'rating', 'key' => 'platform_link', 'value' => 'Link'],
        ];

        foreach ($translations as &$translation) {
            $translation['language_id'] = $languageId;
            $translation['created_at'] = now();
            $translation['updated_at'] = now();
        }

        DB::table('translations')->insert($translations);
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
