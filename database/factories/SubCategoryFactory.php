<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use OverflowException;

/**
 * @extends Factory<SubCategory>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Real subcategories per top-level category from https://www.startech.com.bd/.
     *
     * @var array<string, array<int, string>>
     */
    public const STAR_TECH_SUB_CATEGORIES = [
        'Desktop' => [
            'AI PC', 'Desktop Offer', 'Star PC', 'Gaming PC', 'Brand PC', 'All-in-One PC',
            'Portable Mini PC', 'Apple Mac Mini', 'Apple iMac', 'Apple Mac Studio', 'Apple Mac Pro',
        ],
        'Laptop' => [
            'All Laptop', 'Gaming Laptop', 'Premium Ultrabook', 'Laptop Bag', 'Laptop Accessories',
            'Laptop Finder',
        ],
        'Component' => [
            'Processor', 'CPU Cooler', 'Motherboard', 'Graphics Card', 'RAM (Desktop)',
            'RAM (Laptop)', 'Power Supply', 'Hard Disk Drive', 'Portable Hard Disk Drive', 'SSD',
            'Portable SSD', 'Casing', 'Casing Cooler', 'Optical Disk Drive', 'Vertical GPU Holder',
            'Water / Liquid Cooling',
        ],
        'Monitor' => [
            'Gaming Monitor', 'Curved Monitor', 'Touch Monitor', '4K Monitor', 'Portable Monitor',
            'Monitor Arm',
        ],
        'Power' => [
            'UPS', 'Online UPS', 'Mini UPS', 'Portable Power Station', 'IPS', 'UPS Battery',
            'Voltage Stabilizer', 'Inverter', 'Solar Panel',
        ],
        'Phone' => [
            'Feature Phone', 'iPhone', 'Samsung', 'Google', 'Redmi', 'Realme', 'Vivo', 'OPPO',
            'HONOR', 'HUAWEI', 'OnePlus', 'TECNO', 'Infinix', 'Helio', 'ZTE', 'HTC',
            'Mobile Accessories',
        ],
        'Tablet' => ['Graphics Tablet', 'iPad', 'Stylus Pen'],
        'Office Equipment' => [
            'Projector', 'Conference System', 'PA System', 'Interactive Flat Panel', 'Video Wall',
            'Signage', 'Kiosk', 'Printer', 'Laser Printer', 'Large Format Printer', 'ID Card Printer',
            'POS Printer', 'Label Printer', 'Photocopier', 'Toner', 'Cartridge', 'Ink Bottle',
            'Printer Paper', 'Ribbon', 'Printer Drum', 'Scanner', 'Barcode Scanner', 'Cash Drawer',
            'Telephone Set', 'IP Phone', 'PABX System', 'Money Counting Machine', 'Paper Shredder',
            'Laminating Machine', 'Binding Machine',
        ],
        'Camera' => [
            'Action Camera', 'DSLR', 'Mirrorless Camera', 'Digital Camera', 'Video Camera',
            'Handycam', 'Dash Cam', 'Instant Camera', 'Body Camera', 'Camera Lenses',
            'Camera Tripod', 'Camera Accessories', 'Gimbal',
        ],
        'Security' => [
            'Portable WiFi Camera', 'IP Camera', 'CC Camera', 'PTZ Camera', 'CC Camera Package',
            'IP Camera Package', 'DVR', 'NVR', 'XVR', 'CC Camera Accessories', 'Door Lock',
            'Smart Door Bell', 'Access Control', 'Entrance Control', 'Digital Locker & Vault',
            'KVM Switch',
        ],
        'Networking' => [
            'Starlink', 'Router', 'Pocket Router', 'WiFi Range Extender', 'Access Point',
            'WiFi Adapter', 'Network Switch', 'Firewall', 'ONU', 'OLT', 'Media Converter',
            'Network Transceivers', 'Networking Cable', 'Patch Cord', 'Connector', 'Modular Jack',
            'Faceplate', 'Patch Panel', 'LAN Card', 'PoE Injector', 'Crimping Tool',
            'Splicer Machine', 'Cable Tester',
        ],
        'Software' => [
            'Operating System', 'Office Application', 'Database Server Solution',
            'Mail Server Solution', 'Cloud Solutions', 'Antivirus', 'Bangla Typing Software',
            'Adobe', 'VMware', 'AutoDesk', 'AnyDesk',
        ],
        'Server & Storage' => [
            'Server', 'GPU Server', 'Server Rack', 'Workstation', 'NAS Storage', 'SAN Storage',
            'DAS Storage', 'Server HDD', 'Server HDD Bay', 'Server RAM', 'Server SSD',
            'Server Power Supply',
        ],
        'Accessories' => [
            'Keyboard', 'Mouse', 'Headphone', 'Bluetooth Headphone', 'Speaker & Home Theater',
            'Bluetooth Speakers', 'Soundbar', 'Webcam', 'Cable', 'Converter', 'Card Reader',
            'Hubs & Docks', 'Microphone', 'Digital Voice Recorder', 'Presenter', 'Memory Card',
            'Capture Card', 'Pen Drive', 'Thermal Paste', 'HDD-SSD Enclosure', 'Power Strip',
            'Bluetooth Adapter', 'Monitor Light Bar', 'Watch', 'Mouse Pad', 'Wrist Rest',
            'Headphone Stand',
        ],
        'Gadget' => [
            'Daily Lifestyle', 'Smart Watch', 'Smart Band', 'Analog Watch', 'Earphone', 'Earbuds',
            'Neckband', 'Trimmer', 'Smart Ring', 'Smart Glasses', 'Power Bank', 'Car Charger',
            'Mini Fan', 'Health Monitor', 'TV Box', 'Studio Equipment', 'Drones', 'Gimbal',
            'Calculator', 'Power Tools',
        ],
        'Gaming' => [
            'Gaming Chair', 'Gaming Desk', 'Gaming Console', 'Gaming PC', 'Gaming Laptop',
            'Gaming Monitor', 'Keyboard', 'Mouse', 'Headphone', 'Mouse Pad', 'Gamepad',
            'Racing Wheel', 'VR', 'Games', 'Gaming Router',
        ],
        'TV' => ['All TV', 'LED TV', 'Smart TV', 'Android TV', '4K TV', 'TV Box', 'TV Stand & Wall Mount'],
        'Appliance' => [
            'AC', 'Air Fryer', 'Washing Machine', 'Fridge', 'Geyser', 'Light', 'Room Heater',
            'Air Purifier', 'Coffee Maker', 'Fan', 'Dishwasher', 'Vacuum Cleaner', 'Dehumidifier',
            'Electric Cooker', 'Induction Cooker', 'Oven', 'Blender & Grinder',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => function (array $attributes) {
                $category = isset($attributes['category_id'])
                    ? Category::query()->find($attributes['category_id'])
                    : null;

                return $category !== null
                    ? static::starTechName($category->name)
                    : fake()->unique()->words(2, true);
            },
            'description' => fake()->sentence(),
            'status' => 'published',
        ];
    }

    protected static function starTechName(string $categoryName): string
    {
        $names = static::STAR_TECH_SUB_CATEGORIES[$categoryName] ?? [];

        if ($names === []) {
            return fake()->unique()->words(2, true);
        }

        try {
            return fake()->unique()->randomElement($names);
        } catch (OverflowException) {
            return fake()->unique()->words(2, true);
        }
    }
}
