<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductLink;
use App\Models\Proof;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
    {
    use WithoutModelEvents;

    public function run(): void
    {
        $techNova = Company::create([
            'name' => 'TechNova',
            'slug' => 'technova',
            'website_url' => 'https://technova-shop.example.com',
            'description' => 'Consumer electronics brand selling headphones, smart watches, and accessories. Sources products directly from Shenzhen manufacturers.',
        ]);

        $glowBeauty = Company::create([
            'name' => 'GlowBeauty Co',
            'slug' => 'glowbeauty-co',
            'website_url' => 'https://glowbeauty.example.com',
            'description' => 'Online beauty and skincare brand. Known for repackaging white-label Korean skincare products under their own brand.',
        ]);

        $peakFit = Company::create([
            'name' => 'PeakFit Supplements',
            'slug' => 'peakfit-supplements',
            'website_url' => 'https://peakfit.example.com',
            'description' => 'Fitness supplement company. Their product line matches generic formulas available from Chinese supplement manufacturers.',
        ]);

        $auraHome = Company::create([
            'name' => 'AuraHome Living',
            'slug' => 'aurahome-living',
            'website_url' => 'https://aurahome.example.com',
            'description' => 'Home decor and kitchen gadgets brand. Many of their products are identical to items found on AliExpress and Alibaba.',
        ]);

        $vortexGear = Company::create([
            'name' => 'VortexGear',
            'slug' => 'vortexgear',
            'website_url' => 'https://vortexgear.example.com',
            'description' => 'Gaming peripherals and PC accessories. Products appear to be rebranded items from Shenzhen factories.',
        ]);

        $pureNature = Company::create([
            'name' => 'PureNature Organics',
            'slug' => 'purenature-organics',
            'website_url' => 'https://purenature.example.com',
            'description' => 'Organic wellness and essential oils brand. Sells generic essential oil blends available from multiple Chinese suppliers.',
        ]);

        $skylineAudio = Company::create([
            'name' => 'Skyline Audio',
            'slug' => 'skyline-audio',
            'website_url' => 'https://skylineaudio.example.com',
            'description' => 'Audio equipment brand specializing in wireless earbuds and portable speakers.',
        ]);

        $zenCraft = Company::create([
            'name' => 'ZenCraft',
            'slug' => 'zencraft',
            'website_url' => 'https://zencraft.example.com',
            'description' => 'Handmade crafts and jewelry brand. Despite the handmade branding, most products are mass-produced.',
        ]);

        $nimblePet = Company::create([
            'name' => 'NimblePet',
            'slug' => 'nimblepet',
            'website_url' => 'https://nimblepet.example.com',
            'description' => 'Pet accessories and grooming tools. Several products match generic Alibaba listings.',
        ]);

        $urbanEdge = Company::create([
            'name' => 'UrbanEdge Fashion',
            'slug' => 'urbangedge-fashion',
            'website_url' => 'https://urbangedge.example.com',
            'description' => 'Streetwear and fashion accessories. Known for dropshipping directly from Chinese clothing manufacturers.',
        ]);

        // Products for TechNova
        $this->createProduct($techNova, [
            'name' => 'TechNova ProBass X500',
            'slug' => 'technova-probass-x500',
            'description' => 'Wireless over-ear headphones with active noise cancellation. Packaging and design match a generic Shenzhen OEM model.',
            'serial_number' => 'TN-X500-BLK',
            'rating' => 8,
            'company_url' => 'https://technova-shop.example.com/products/probass-x500',
        ], [
            ['type' => 'text', 'content' => 'The PCB board inside reveals a generic BT5.0 module manufactured by ShenZhen BT Electronics. The same module is used in dozens of other branded headphones sold on AliExpress.', 'description' => 'Internal hardware analysis'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005001234567.html', 'description' => 'Identical product on AliExpress at 1/4 of the price'],
            ['type' => 'image', 'content' => 'https://placehold.co/600x400/png?text=PCB+Comparison', 'description' => 'Side-by-side PCB comparison'],
        ], [
            'aliexpress',
        ]);

        $this->createProduct($techNova, [
            'name' => 'TechNova FitBand Lite',
            'slug' => 'technova-fitband-lite',
            'description' => 'Budget fitness tracker with heart rate monitor. Uses a generic reference design from a Shenzhen OEM.',
            'serial_number' => 'TN-FBL-2024',
            'rating' => 7,
            'company_url' => 'https://technova-shop.example.com/products/fitband-lite',
        ], [
            ['type' => 'text', 'content' => 'The companion app connects to a generic cloud platform (H Band) used by over 100 different fitness tracker brands. This confirms the product uses an off-the-shelf solution.', 'description' => 'Software analysis'],
            ['type' => 'link', 'content' => 'https://www.made-in-china.com/products/fitness-tracker-band.html', 'description' => 'Same design on Made-in-China'],
        ], [
            'aliexpress',
            'made-in-china',
        ]);

        $this->createProduct($techNova, [
            'name' => 'TechNova SmartLens 4K',
            'slug' => 'technova-smartlens-4k',
            'description' => '4K action camera with image stabilization. Firmware dump reveals generic Ambarella chipset.',
            'serial_number' => 'TN-SL4K',
            'rating' => 9,
            'company_url' => 'https://technova-shop.example.com/products/smartlens-4k',
        ], [
            ['type' => 'text', 'content' => 'Firmware version string contains "AOKUO_CAM" which is a known OEM manufacturer in Shenzhen. The exact same firmware is found in multiple budget action cameras.', 'description' => 'Firmware analysis'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005009876543.html', 'description' => 'Identical camera on AliExpress'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/4k-action-camera-oem.html', 'description' => 'OEM listing on Alibaba'],
            ['type' => 'text', 'content' => 'The housing mold marks show "AK-2023-V2" which is a standard AOKUO mold number used by multiple brands.', 'description' => 'Physical inspection notes'],
        ], [
            'aliexpress',
            'alibaba',
        ]);

        // Products for GlowBeauty
        $this->createProduct($glowBeauty, [
            'name' => 'GlowBeauty Hydra-Glow Serum',
            'slug' => 'glowbeauty-hydra-glow-serum',
            'description' => 'Hyaluronic acid serum marketed as a proprietary formula. Ingredient list matches generic Korean OEM serums.',
            'serial_number' => 'GB-HGS-30ML',
            'rating' => 8,
            'company_url' => 'https://glowbeauty.example.com/products/hydra-glow-serum',
        ], [
            ['type' => 'text', 'content' => 'INCI ingredient list is identical to the generic "HA Serum Plus" formula offered by Cosmax and other Korean OEM manufacturers. The concentration ratios match the standard formulation.', 'description' => 'Ingredient analysis'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/hyaluronic-acid-serum-oem.html', 'description' => 'OEM supplier listing on Alibaba'],
        ], [
            'alibaba',
        ]);

        $this->createProduct($glowBeauty, [
            'name' => 'GlowBeauty Vitamin C Brightening Cream',
            'slug' => 'glowbeauty-vitamin-c-cream',
            'description' => 'Vitamin C face cream with aloe vera. The formulation is available from multiple Chinese cosmetics OEMs.',
            'serial_number' => 'GB-VCC-50ML',
            'rating' => 7,
        ], [
            ['type' => 'text', 'content' => 'Batch number format and manufacturing date stamp follow the standard format used by Guangzhou Baiyun cosmetics factories.', 'description' => 'Manufacturing traceability'],
            ['type' => 'link', 'content' => 'https://www.made-in-china.com/products/vitamin-c-cream.html', 'description' => 'Same formula on Made-in-China'],
        ], [
            'made-in-china',
        ]);

        // Products for PeakFit
        $this->createProduct($peakFit, [
            'name' => 'PeakFit Mass Gainer 3000',
            'slug' => 'peakfit-mass-gainer-3000',
            'description' => 'High-calorie mass gainer supplement. Lab analysis shows identical formula to generic Chinese supplement manufacturers.',
            'serial_number' => 'PF-MG3K-VAN',
            'rating' => 9,
            'company_url' => 'https://peakfit.example.com/products/mass-gainer-3000',
        ], [
            ['type' => 'text', 'content' => 'Third-party lab analysis shows the amino acid profile is identical to the generic "MG-Formula-A" sold by several Chinese supplement OEMs. The protein source is listed as a generic whey concentrate blend.', 'description' => 'Lab analysis report'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/mass-gainer-supplement-oem.html', 'description' => 'OEM supplier on Alibaba'],
            ['type' => 'text', 'content' => 'The scoop included in the container has a mold number that matches a standard Alibaba supplier mold.', 'description' => 'Packaging analysis'],
        ], [
            'alibaba',
            'made-in-china',
        ]);

        $this->createProduct($peakFit, [
            'name' => 'PeakFit Pre-Workout Ignite',
            'slug' => 'peakfit-pre-workout-ignite',
            'description' => 'Pre-workout powder with caffeine and beta-alanine. Standard formula available from multiple OEM suppliers.',
            'serial_number' => 'PF-PWI-FRU',
            'rating' => 6,
        ], [
            ['type' => 'text', 'content' => 'The ingredient list is a standard pre-workout formula (caffeine, beta-alanine, citrulline malate) that is available from dozens of Chinese supplement OEMs at commodity pricing.', 'description' => 'Formula comparison'],
        ], [
            'alibaba',
        ]);

        // Products for AuraHome
        $this->createProduct($auraHome, [
            'name' => 'AuraHome LED Sunset Lamp',
            'slug' => 'aurahome-led-sunset-lamp',
            'description' => 'Trending sunset projection lamp. Identical to products sold under dozens of different brand names on AliExpress.',
            'serial_number' => 'AH-SSL-RGB',
            'rating' => 10,
            'company_url' => 'https://aurahome.example.com/products/sunset-lamp',
        ], [
            ['type' => 'text', 'content' => 'The product was purchased directly from AuraHome and compared side-by-side with the same item from AliExpress ($8 vs $35). The products are identical down to the same mold lines and LED color temperature.', 'description' => 'Direct comparison test'],
            ['type' => 'image', 'content' => 'https://placehold.co/600x400/png?text=Side+by+Side+Comparison', 'description' => 'Photo comparison - identical products'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005004567890.html', 'description' => 'AliExpress listing at $8'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/sunset-projection-lamp.html', 'description' => 'Alibaba bulk listing at $3/unit'],
        ], [
            'aliexpress',
            'alibaba',
        ]);

        $this->createProduct($auraHome, [
            'name' => 'AuraHome Aromatherapy Diffuser',
            'slug' => 'aurahome-aromatherapy-diffuser',
            'description' => 'Ultrasonic essential oil diffuser with color-changing LED lights. Generic OEM product.',
            'serial_number' => 'AH-AD-300ML',
            'rating' => 8,
        ], [
            ['type' => 'text', 'content' => 'The internal ultrasonic transducer and PCB are identical to a common OEM design. The user manual still contains references to the original Chinese manufacturer.', 'description' => 'Teardown analysis'],
            ['type' => 'link', 'content' => 'https://www.made-in-china.com/products/aromatherapy-diffuser.html', 'description' => 'Made-in-China listing'],
        ], [
            'made-in-china',
            'aliexpress',
        ]);

        $this->createProduct($auraHome, [
            'name' => 'AuraHome Magnetic Spice Rack',
            'slug' => 'aurahome-magnetic-spice-rack',
            'description' => 'Wall-mounted magnetic spice jar set. Design matches multiple Alibaba listings.',
            'serial_number' => 'AH-MSR-6PK',
            'rating' => 7,
        ], [
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/magnetic-spice-rack-set.html', 'description' => 'Alibaba supplier with identical product'],
            ['type' => 'text', 'content' => 'Product dimensions and magnet strength specifications match the Alibaba listing exactly. Even the jar cap color options are the same.', 'description' => 'Specification comparison'],
        ], [
            'alibaba',
        ]);

        // Products for VortexGear
        $this->createProduct($vortexGear, [
            'name' => 'VortexGear Mechanical Keyboard K75',
            'slug' => 'vortexgear-k75',
            'description' => '75% mechanical keyboard with hot-swappable switches. Uses a generic PCB design from a Shenzhen keyboard OEM.',
            'serial_number' => 'VG-K75-RGB',
            'rating' => 8,
            'company_url' => 'https://vortexgear.example.com/products/k75',
        ], [
            ['type' => 'text', 'content' => 'The PCB has a marking "SZ-KB-75-V3" which is a known Shenzhen keyboard PCB manufacturer. The same PCB is used in at least 5 other budget mechanical keyboard brands.', 'description' => 'PCB identification'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/75-percent-mechanical-keyboard-oem.html', 'description' => 'OEM keyboard on Alibaba'],
        ], [
            'alibaba',
            'aliexpress',
        ]);

        $this->createProduct($vortexGear, [
            'name' => 'VortexGear RGB Gaming Mouse',
            'slug' => 'vortexgear-rgb-mouse',
            'description' => 'Lightweight gaming mouse with adjustable DPI. Uses a common PixArt sensor and generic shell mold.',
            'serial_number' => 'VG-RGBM-BK',
            'rating' => 7,
        ], [
            ['type' => 'text', 'content' => 'The shell mold is identical to the "GM-200" model from Shenzhen Winry Electronics. The sensor (PixArt PAW3325) is a budget option used in many OEM mice.', 'description' => 'Hardware teardown'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005007890123.html', 'description' => 'Same mouse shell on AliExpress'],
        ], [
            'aliexpress',
        ]);

        // Products for PureNature
        $this->createProduct($pureNature, [
            'name' => 'PureNature Lavender Essential Oil Set',
            'slug' => 'purenature-lavender-eo-set',
            'description' => 'Set of 6 essential oils including lavender, eucalyptus, and tea tree. Bottles and packaging match generic Alibaba sets.',
            'serial_number' => 'PN-EO-LAV6',
            'rating' => 9,
            'company_url' => 'https://purenature.example.com/products/lavender-set',
        ], [
            ['type' => 'text', 'content' => 'GC-MS analysis of the lavender oil shows it matches the profile of generic Chinese lavender oil (Lavandula angustifolia from Yunnan province) rather than French or Bulgarian lavender as claimed.', 'description' => 'Chemical analysis'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/essential-oil-set-6.html', 'description' => 'Identical set on Alibaba'],
            ['type' => 'image', 'content' => 'https://placehold.co/600x400/png?text=Bottle+Comparison', 'description' => 'Bottle cap and label comparison'],
        ], [
            'alibaba',
        ]);

        $this->createProduct($pureNature, [
            'name' => 'PureNature Organic Face Mist',
            'slug' => 'purenature-organic-face-mist',
            'description' => 'Rose water facial spray. Packaging and formula match generic OEM face mists.',
            'serial_number' => 'PN-OFM-100ML',
            'rating' => 6,
        ], [
            ['type' => 'text', 'content' => 'The ingredient list shows "Rosa Damascena Flower Water" as the main ingredient, but the low price point and batch number format suggest it is a diluted generic rose water from Chinese suppliers.', 'description' => 'Ingredient analysis'],
        ], [
            'made-in-china',
        ]);

        // Products for Skyline Audio
        $this->createProduct($skylineAudio, [
            'name' => 'Skyline Audio BassPods Pro',
            'slug' => 'skyline-audio-basspods-pro',
            'description' => 'True wireless earbuds with ANC. Uses a generic TWS chipset from JL (JieLi) Electronics.',
            'serial_number' => 'SA-BPP-2024',
            'rating' => 8,
            'company_url' => 'https://skylineaudio.example.com/products/basspods-pro',
        ], [
            ['type' => 'text', 'content' => 'The Bluetooth chip (JL AC6983D) is a common budget TWS chipset. The charging case PCB has a marking from the Shenzhen OEM that manufactured it. The same chipset and design is found in at least 20 other TWS earbuds on AliExpress.', 'description' => 'Chipset analysis'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005002345678.html', 'description' => 'Same chipset earbuds on AliExpress'],
        ], [
            'aliexpress',
            'alibaba',
        ]);

        $this->createProduct($skylineAudio, [
            'name' => 'Skyline Audio BoomBox Mini',
            'slug' => 'skyline-audio-boombox-mini',
            'description' => 'Portable Bluetooth speaker with LED lights. Generic Chinese speaker with brand sticker.',
            'serial_number' => 'SA-BBM-BLU',
            'rating' => 7,
        ], [
            ['type' => 'link', 'content' => 'https://www.made-in-china.com/products/bluetooth-speaker-led.html', 'description' => 'Identical speaker on Made-in-China'],
        ], [
            'made-in-china',
        ]);

        // Products for ZenCraft (lower ratings - less obvious private labeling)
        $this->createProduct($zenCraft, [
            'name' => 'ZenCraft Crystal Necklace',
            'slug' => 'zencraft-crystal-necklace',
            'description' => 'Natural amethyst crystal pendant necklace. Despite handmade claims, identical necklaces are mass-produced.',
            'serial_number' => 'ZC-CN-AME',
            'rating' => 5,
        ], [
            ['type' => 'text', 'content' => 'The crystal pendant shape and wire wrapping pattern are identical across multiple Alibaba jewelry suppliers. While the materials may be genuine, the production is clearly industrial.', 'description' => 'Manufacturing analysis'],
        ], [
            'alibaba',
        ]);

        $this->createProduct($zenCraft, [
            'name' => 'ZenCraft Macrame Wall Hanging',
            'slug' => 'zencraft-macrame-wall-hanging',
            'description' => 'Bohemian macrame wall decor. Design appears to be a common pattern from mass-production suppliers.',
            'serial_number' => 'ZC-MWH-LGE',
            'rating' => 4,
        ], [
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/macrame-wall-hanging.html', 'description' => 'Similar design on Alibaba'],
        ], [
            'alibaba',
        ]);

        // Products for NimblePet
        $this->createProduct($nimblePet, [
            'name' => 'NimblePet Self-Cleaning Slicker Brush',
            'slug' => 'nimblepet-slicker-brush',
            'description' => 'Pet grooming brush with self-cleaning button. Identical to generic Alibaba pet brush listings.',
            'serial_number' => 'NP-SCB-LGE',
            'rating' => 8,
        ], [
            ['type' => 'text', 'content' => 'The self-cleaning mechanism, handle mold, and bristle pattern are identical to the "Pet Brush Model PB-300" sold by multiple Alibaba suppliers. Even the button spring tension is the same.', 'description' => 'Product comparison'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/self-cleaning-pet-brush.html', 'description' => 'Alibaba supplier listing'],
            ['type' => 'image', 'content' => 'https://placehold.co/600x400/png?text=Brush+Comparison', 'description' => 'Side-by-side comparison photo'],
        ], [
            'alibaba',
            'aliexpress',
        ]);

        $this->createProduct($nimblePet, [
            'name' => 'NimblePet LED Dog Collar',
            'slug' => 'nimblepet-led-dog-collar',
            'description' => 'Rechargeable LED dog collar for night walks. Generic product available from many suppliers.',
            'serial_number' => 'NP-LDC-MED',
            'rating' => 7,
        ], [
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005005678901.html', 'description' => 'Same collar on AliExpress'],
        ], [
            'aliexpress',
        ]);

        // Products for UrbanEdge
        $this->createProduct($urbanEdge, [
            'name' => 'UrbanEdge Crossbody Sling Bag',
            'slug' => 'urbangedge-sling-bag',
            'description' => 'Unisex anti-theft crossbody bag. Design and materials match generic Alibaba bag listings.',
            'serial_number' => 'UE-SB-BLK',
            'rating' => 9,
            'company_url' => 'https://urbangedge.example.com/products/sling-bag',
        ], [
            ['type' => 'text', 'content' => 'The zipper pull branding was removed but the mold marks underneath show "YKK-alternative" zippers commonly used in Chinese bag factories. The strap adjustment mechanism and pocket layout are identical to a popular Alibaba OEM model.', 'description' => 'Material and construction analysis'],
            ['type' => 'link', 'content' => 'https://www.alibaba.com/product-detail/anti-theft-sling-bag.html', 'description' => 'OEM bag on Alibaba'],
            ['type' => 'link', 'content' => 'https://www.aliexpress.com/item/1005006789012.html', 'description' => 'Same bag on AliExpress at 1/5 price'],
        ], [
            'alibaba',
            'aliexpress',
        ]);

        $this->createProduct($urbanEdge, [
            'name' => 'UrbanEdge Minimalist Watch',
            'slug' => 'urbangedge-minimalist-watch',
            'description' => 'Quartz movement minimalist watch. Movement and case come from standard Chinese watch suppliers.',
            'serial_number' => 'UE-MW-SLV',
            'rating' => 6,
        ], [
            ['type' => 'text', 'content' => 'The quartz movement (PC21S) is a standard Chinese movement used in thousands of budget watches. The case design follows a common minimalist template available from Guangzhou watch factories.', 'description' => 'Movement analysis'],
        ], [
            'made-in-china',
        ]);

        $this->createProduct($urbanEdge, [
            'name' => 'UrbanEdge UV Protection Sunglasses',
            'slug' => 'urbangedge-uv-sunglasses',
            'description' => 'Polarized sunglasses with UV400 protection. Frame design matches generic Alibaba eyewear listings.',
            'serial_number' => 'UE-UVS-BRN',
            'rating' => 5,
        ], [
            ['type' => 'link', 'content' => 'https://www.made-in-china.com/products/polarized-sunglasses.html', 'description' => 'Same frame design on Made-in-China'],
        ], [
            'made-in-china',
        ]);
    }

    private function createProduct(Company $company, array $attributes, array $proofs, array $linkPlatforms = []): void
    {
        $product = $company->products()->create($attributes);

        foreach ($proofs as $proof) {
            $product->proofs()->create($proof);
        }

        foreach ($linkPlatforms as $platform) {
            $product->links()->create([
                'url' => match ($platform) {
                    'aliexpress' => 'https://www.aliexpress.com/item/' . fake()->numerify('##########') . '.html',
                    'made-in-china' => 'https://www.made-in-china.com/products/' . fake()->slug() . '.html',
                    'alibaba' => 'https://www.alibaba.com/product-detail/' . fake()->slug() . '.html',
                    'company' => $company->website_url ?? fake()->url(),
                    default => fake()->url(),
                },
                'platform' => $platform,
                'label' => match ($platform) {
                    'aliexpress' => 'View on AliExpress',
                    'made-in-china' => 'View on Made-in-China',
                    'alibaba' => 'View on Alibaba',
                    'company' => 'Company page',
                    default => 'View product',
                },
            ]);
        }
    }
}
