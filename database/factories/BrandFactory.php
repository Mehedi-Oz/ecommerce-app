<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use OverflowException;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Real brands stocked by https://www.startech.com.bd/.
     *
     * @var array<int, string>
     */
    public const STAR_TECH_BRANDS = [
        'A4Tech',
        'Acer',
        'Adata',
        'AMD',
        'Anker',
        'Antec',
        'AOC',
        'Apacer',
        'Apple',
        'Apollo',
        'ASRock',
        'Asus',
        'Audio Technica',
        'AVerMedia',
        'Awei',
        'Baseus',
        'beko',
        'BenQ',
        'Beyerdynamic',
        'BOSCH',
        'Bose',
        'Brother',
        'CableMaster',
        'Canon',
        'Casio',
        'Cisco',
        'Colorful',
        'Cooler Master',
        'Corsair',
        'Cougar',
        'Cudy',
        'D-Link',
        'DAHUA',
        'Daikin',
        'DeepCool',
        'Dell',
        'DJI',
        'DIZO',
        'EarFun',
        'EcoFlow',
        'Edifier',
        'Epson',
        'EZVIZ',
        'F&D',
        'Fantech',
        'G.Skill',
        'Gamdias',
        'Gigabyte',
        'GoPro',
        'Grandstream',
        'Havit',
        'HiFuture',
        'HikVision',
        'Hitachi',
        'HKC',
        'Hoco',
        'HONOR',
        'HP',
        'HTC',
        'HUAWEI',
        'Imou',
        'Infinix',
        'INNO3D',
        'Intel',
        'Jabra',
        'JBL',
        'Kingston',
        'LG',
        'Lenovo',
        'Lexar',
        'Logitech',
        'MaxGreen',
        'Mercusys',
        'Microsoft',
        'Midea',
        'MikroTik',
        'MSI',
        'Netac',
        'NETGEAR',
        'Nikon',
        'Nintendo',
        'Nokia',
        'NVIDIA',
        'NZXT',
        'OnePlus',
        'OPPO',
        'Oraimo',
        'Panasonic',
        'Philips',
        'PlayStation',
        'PNY',
        'PowerColor',
        'Prolink',
        'Razer',
        'Realme',
        'Redmi',
        'Redragon',
        'Ruijie',
        'Samsung',
        'SanDisk',
        'Sapphire',
        'Seagate',
        'Sharp',
        'Singer',
        'SJCAM',
        'Smart',
        'Sony',
        'SteelSeries',
        'Synology',
        'TCL',
        'Team',
        'TECNO',
        'Tenda',
        'Teclast',
        'Thermaltake',
        'TP-Link',
        'Toshiba',
        'Transcend',
        'UGREEN',
        'Uniview',
        'ViewSonic',
        'Vivo',
        'Walton',
        'Western Digital',
        'Xiaomi',
        'Xtrike Me',
        'ZOTAC',
        'ZYXEL',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => static::uniqueStarTechBrand(),
            'description' => fake()->sentence(),
            'image' => null,
            'status' => 'published',
        ];
    }

    protected static function uniqueStarTechBrand(): string
    {
        $available = array_values(array_diff(
            static::STAR_TECH_BRANDS,
            Brand::query()->pluck('name')->all()
        ));

        if ($available !== []) {
            try {
                return fake()->unique()->randomElement($available);
            } catch (OverflowException) {
                // Fall through to a generated name below.
            }
        }

        try {
            return fake()->unique()->company();
        } catch (OverflowException) {
            return fake()->unique()->bothify('Brand-####');
        }
    }
}
