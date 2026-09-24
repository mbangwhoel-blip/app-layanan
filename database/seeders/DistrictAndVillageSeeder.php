<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;

class DistrictAndVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds 22 districts (kecamatan) in Kabupaten Blitar and their villages.
     */
    public function run(): void
    {
        $districts = [
            [
                'code' => '35.05.01',
                'name' => 'Bakung',
                'villages' => [
                    ['code' => '35.05.01.2001', 'name' => 'Bakung'],
                    ['code' => '35.05.01.2002', 'name' => 'Bululawang'],
                    ['code' => '35.05.01.2003', 'name' => 'Kedungbanteng'],
                    ['code' => '35.05.01.2004', 'name' => 'Lorenz'],
                    ['code' => '35.05.01.2005', 'name' => 'Ngrejo'],
                    ['code' => '35.05.01.2006', 'name' => 'Plandirejo'],
                    ['code' => '35.05.01.2007', 'name' => 'Sidomulyo'],
                    ['code' => '35.05.01.2008', 'name' => 'Tumpakkepuh'],
                ],
            ],
            [
                'code' => '35.05.02',
                'name' => 'Wonotirto',
                'villages' => [
                    ['code' => '35.05.02.2001', 'name' => 'Wonotirto'],
                    ['code' => '35.05.02.2002', 'name' => 'Gununggede'],
                    ['code' => '35.05.02.2003', 'name' => 'Kaligrenjeng'],
                    ['code' => '35.05.02.2004', 'name' => 'Ngeni'],
                    ['code' => '35.05.02.2005', 'name' => 'Ngadipuro'],
                    ['code' => '35.05.02.2006', 'name' => 'Pasiraman'],
                    ['code' => '35.05.02.2007', 'name' => 'Sumberboto'],
                    ['code' => '35.05.02.2008', 'name' => 'Tambakrejo'],
                ],
            ],
            [
                'code' => '35.05.03',
                'name' => 'Panggungrejo',
                'villages' => [
                    ['code' => '35.05.03.2001', 'name' => 'Panggungrejo'],
                    ['code' => '35.05.03.2002', 'name' => 'Balerejo'],
                    ['code' => '35.05.03.2003', 'name' => 'Bumiayu'],
                    ['code' => '35.05.03.2004', 'name' => 'Kaligambir'],
                    ['code' => '35.05.03.2005', 'name' => 'Kalitengah'],
                    ['code' => '35.05.03.2006', 'name' => 'Margomulyo'],
                    ['code' => '35.05.03.2007', 'name' => 'Panggungasri'],
                    ['code' => '35.05.03.2008', 'name' => 'Serang'],
                    ['code' => '35.05.03.2009', 'name' => 'Sumberagung'],
                ],
            ],
            [
                'code' => '35.05.04',
                'name' => 'Wates',
                'villages' => [
                    ['code' => '35.05.04.2001', 'name' => 'Wates'],
                    ['code' => '35.05.04.2002', 'name' => 'Mojorejo'],
                    ['code' => '35.05.04.2003', 'name' => 'Purworejo'],
                    ['code' => '35.05.04.2004', 'name' => 'Ringinrejo'],
                    ['code' => '35.05.04.2005', 'name' => 'Sukorejo'],
                    ['code' => '35.05.04.2006', 'name' => 'Sumberwungu'],
                    ['code' => '35.05.04.2007', 'name' => 'Tugurejo'],
                ],
            ],
            [
                'code' => '35.05.05',
                'name' => 'Binangun',
                'villages' => [
                    ['code' => '35.05.05.2001', 'name' => 'Binangun'],
                    ['code' => '35.05.05.2002', 'name' => 'Birowo'],
                    ['code' => '35.05.05.2003', 'name' => 'Kedungwungu'],
                    ['code' => '35.05.05.2004', 'name' => 'Ngadri'],
                    ['code' => '35.05.05.2005', 'name' => 'Ngembul'],
                    ['code' => '35.05.05.2006', 'name' => 'Rejoso'],
                    ['code' => '35.05.05.2007', 'name' => 'Sambigede'],
                    ['code' => '35.05.05.2008', 'name' => 'Sukorame'],
                    ['code' => '35.05.05.2009', 'name' => 'Tawangrejo'],
                ],
            ],
            [
                'code' => '35.05.06',
                'name' => 'Sutojayan',
                'villages' => [
                    ['code' => '35.05.06.1001', 'name' => 'Kelurahan Sutojayan'],
                    ['code' => '35.05.06.1002', 'name' => 'Kelurahan Kalipang'],
                    ['code' => '35.05.06.1003', 'name' => 'Kelurahan Kembangarum'],
                    ['code' => '35.05.06.1004', 'name' => 'Kelurahan Kedungbunder'],
                    ['code' => '35.05.06.1005', 'name' => 'Kelurahan Sukorejo'],
                    ['code' => '35.05.06.2006', 'name' => 'Pandanarum'],
                    ['code' => '35.05.06.2007', 'name' => 'Jatisari'],
                ],
            ],
            [
                'code' => '35.05.07',
                'name' => 'Kademangan',
                'villages' => [
                    ['code' => '35.05.07.1001', 'name' => 'Kelurahan Kademangan'],
                    ['code' => '35.05.07.2002', 'name' => 'Dawuhan'],
                    ['code' => '35.05.07.2003', 'name' => 'Jimbe'],
                    ['code' => '35.05.07.2004', 'name' => 'Kebonsari'],
                    ['code' => '35.05.07.2005', 'name' => 'Maron'],
                    ['code' => '35.05.07.2006', 'name' => 'Pakisaji'],
                    ['code' => '35.05.07.2007', 'name' => 'Panggungduwet'],
                    ['code' => '35.05.07.2008', 'name' => 'Plumpungrejo'],
                    ['code' => '35.05.07.2009', 'name' => 'Rejowinangun'],
                    ['code' => '35.05.07.2010', 'name' => 'Suruhwadang'],
                ],
            ],
            [
                'code' => '35.05.08',
                'name' => 'Kanigoro',
                'villages' => [
                    ['code' => '35.05.08.1001', 'name' => 'Kelurahan Kanigoro'],
                    ['code' => '35.05.08.1002', 'name' => 'Kelurahan Satreyan'],
                    ['code' => '35.05.08.2003', 'name' => 'Babadan'],
                    ['code' => '35.05.08.2004', 'name' => 'Banggle'],
                    ['code' => '35.05.08.2005', 'name' => 'Gaprang'],
                    ['code' => '35.05.08.2006', 'name' => 'Gogodeso'],
                    ['code' => '35.05.08.2007', 'name' => 'Jatinom'],
                    ['code' => '35.05.08.2008', 'name' => 'Karangsono'],
                    ['code' => '35.05.08.2009', 'name' => 'Kuningan'],
                    ['code' => '35.05.08.2010', 'name' => 'Minggirsari'],
                    ['code' => '35.05.08.2011', 'name' => 'Papungan'],
                    ['code' => '35.05.08.2012', 'name' => 'Sawentar'],
                    ['code' => '35.05.08.2013', 'name' => 'Tlogo'],
                ],
            ],
            [
                'code' => '35.05.09',
                'name' => 'Talun',
                'villages' => [
                    ['code' => '35.05.09.1001', 'name' => 'Kelurahan Talun'],
                    ['code' => '35.05.09.1002', 'name' => 'Kelurahan Kamulan'],
                    ['code' => '35.05.09.1003', 'name' => 'Kelurahan Bajang'],
                    ['code' => '35.05.09.2004', 'name' => 'Bendosewu'],
                    ['code' => '35.05.09.2005', 'name' => 'Duren'],
                    ['code' => '35.05.09.2006', 'name' => 'Jabung'],
                    ['code' => '35.05.09.2007', 'name' => 'Jajar'],
                    ['code' => '35.05.09.2008', 'name' => 'Pasirharjo'],
                    ['code' => '35.05.09.2009', 'name' => 'Sragi'],
                    ['code' => '35.05.09.2010', 'name' => 'Tumpang'],
                    ['code' => '35.05.09.2011', 'name' => 'Wonorejo'],
                ],
            ],
            [
                'code' => '35.05.10',
                'name' => 'Selopuro',
                'villages' => [
                    ['code' => '35.05.10.2001', 'name' => 'Selopuro'],
                    ['code' => '35.05.10.2002', 'name' => 'Jambewangi'],
                    ['code' => '35.05.10.2003', 'name' => 'Jatitengah'],
                    ['code' => '35.05.10.2004', 'name' => 'Mandesan'],
                    ['code' => '35.05.10.2005', 'name' => 'Mronjo'],
                    ['code' => '35.05.10.2006', 'name' => 'Ploso'],
                    ['code' => '35.05.10.2007', 'name' => 'Popoh'],
                    ['code' => '35.05.10.2008', 'name' => 'Tegalrejo'],
                ],
            ],
            [
                'code' => '35.05.11',
                'name' => 'Kesamben',
                'villages' => [
                    ['code' => '35.05.11.2001', 'name' => 'Kesamben'],
                    ['code' => '35.05.11.2002', 'name' => 'Babadan'],
                    ['code' => '35.05.11.2003', 'name' => 'Jugo'],
                    ['code' => '35.05.11.2004', 'name' => 'Kemirigede'],
                    ['code' => '35.05.11.2005', 'name' => 'Pagergunung'],
                    ['code' => '35.05.11.2006', 'name' => 'Pagerwojo'],
                    ['code' => '35.05.11.2007', 'name' => 'Siraman'],
                    ['code' => '35.05.11.2008', 'name' => 'Sukoanyar'],
                    ['code' => '35.05.11.2009', 'name' => 'Tapakrejo'],
                ],
            ],
            [
                'code' => '35.05.12',
                'name' => 'Wlingi',
                'villages' => [
                    ['code' => '35.05.12.1001', 'name' => 'Kelurahan Wlingi'],
                    ['code' => '35.05.12.1002', 'name' => 'Kelurahan Beru'],
                    ['code' => '35.05.12.1003', 'name' => 'Kelurahan Babadan'],
                    ['code' => '35.05.12.1004', 'name' => 'Kelurahan Klemunan'],
                    ['code' => '35.05.12.1005', 'name' => 'Kelurahan Tangkil'],
                    ['code' => '35.05.12.1006', 'name' => 'Kelurahan Tembalang'],
                    ['code' => '35.05.12.2007', 'name' => 'Balerejo'],
                    ['code' => '35.05.12.2008', 'name' => 'Ngadirenggo'],
                    ['code' => '35.05.12.2009', 'name' => 'Tegalasri'],
                ],
            ],
            [
                'code' => '35.05.13',
                'name' => 'Doko',
                'villages' => [
                    ['code' => '35.05.13.2001', 'name' => 'Doko'],
                    ['code' => '35.05.13.2002', 'name' => 'Genengan'],
                    ['code' => '35.05.13.2003', 'name' => 'Jambepawon'],
                    ['code' => '35.05.13.2004', 'name' => 'Kalimanis'],
                    ['code' => '35.05.13.2005', 'name' => 'Plumbangan'],
                    ['code' => '35.05.13.2006', 'name' => 'Resapombo'],
                    ['code' => '35.05.13.2007', 'name' => 'Sooko'],
                    ['code' => '35.05.13.2008', 'name' => 'Suru'],
                    ['code' => '35.05.13.2009', 'name' => 'Sumberurip'],
                ],
            ],
            [
                'code' => '35.05.14',
                'name' => 'Gandusari',
                'villages' => [
                    ['code' => '35.05.14.2001', 'name' => 'Gandusari'],
                    ['code' => '35.05.14.2002', 'name' => 'Butun'],
                    ['code' => '35.05.14.2003', 'name' => 'Gadungan'],
                    ['code' => '35.05.14.2004', 'name' => 'Gondang'],
                    ['code' => '35.05.14.2005', 'name' => 'Kotes'],
                    ['code' => '35.05.14.2006', 'name' => 'Krisik'],
                    ['code' => '35.05.14.2007', 'name' => 'Ngaringan'],
                    ['code' => '35.05.14.2008', 'name' => 'Semen'],
                    ['code' => '35.05.14.2009', 'name' => 'Slumbung'],
                    ['code' => '35.05.14.2010', 'name' => 'Sukosewu'],
                    ['code' => '35.05.14.2011', 'name' => 'Tambakan'],
                    ['code' => '35.05.14.2012', 'name' => 'Tulungrejo'],
                ],
            ],
            [
                'code' => '35.05.15',
                'name' => 'Garum',
                'villages' => [
                    ['code' => '35.05.15.1001', 'name' => 'Kelurahan Garum'],
                    ['code' => '35.05.15.1002', 'name' => 'Kelurahan Tawangsari'],
                    ['code' => '35.05.15.1003', 'name' => 'Kelurahan Bence'],
                    ['code' => '35.05.15.1004', 'name' => 'Kelurahan Sumberdiren'],
                    ['code' => '35.05.15.2005', 'name' => 'Karanganyar'],
                    ['code' => '35.05.15.2006', 'name' => 'Pojok'],
                    ['code' => '35.05.15.2007', 'name' => 'Sidodadi'],
                    ['code' => '35.05.15.2008', 'name' => 'Slorok'],
                    ['code' => '35.05.15.2009', 'name' => 'Tingal'],
                ],
            ],
            [
                'code' => '35.05.16',
                'name' => 'Nglegok',
                'villages' => [
                    ['code' => '35.05.16.1001', 'name' => 'Kelurahan Nglegok'],
                    ['code' => '35.05.16.2002', 'name' => 'Bangsri'],
                    ['code' => '35.05.16.2003', 'name' => 'Dayu'],
                    ['code' => '35.05.16.2004', 'name' => 'Jiwut'],
                    ['code' => '35.05.16.2005', 'name' => 'Kedawung'],
                    ['code' => '35.05.16.2006', 'name' => 'Kemloko'],
                    ['code' => '35.05.16.2007', 'name' => 'Krenceng'],
                    ['code' => '35.05.16.2008', 'name' => 'Modangan'],
                    ['code' => '35.05.16.2009', 'name' => 'Ngoran'],
                    ['code' => '35.05.16.2010', 'name' => 'Penataran'],
                    ['code' => '35.05.16.2011', 'name' => 'Sumberasri'],
                ],
            ],
            [
                'code' => '35.05.17',
                'name' => 'Sanankulon',
                'villages' => [
                    ['code' => '35.05.17.2001', 'name' => 'Sanankulon'],
                    ['code' => '35.05.17.2002', 'name' => 'Bendosari'],
                    ['code' => '35.05.17.2003', 'name' => 'Gledug'],
                    ['code' => '35.05.17.2004', 'name' => 'Jeding'],
                    ['code' => '35.05.17.2005', 'name' => 'Kalipucung'],
                    ['code' => '35.05.17.2006', 'name' => 'Plosoarang'],
                    ['code' => '35.05.17.2007', 'name' => 'Purworejo'],
                    ['code' => '35.05.17.2008', 'name' => 'Sumber'],
                    ['code' => '35.05.17.2009', 'name' => 'Sumberasri'],
                    ['code' => '35.05.17.2010', 'name' => 'Sumberjo'],
                    ['code' => '35.05.17.2011', 'name' => 'Tuliskriyo'],
                ],
            ],
            [
                'code' => '35.05.18',
                'name' => 'Ponggok',
                'villages' => [
                    ['code' => '35.05.18.2001', 'name' => 'Ponggok'],
                    ['code' => '35.05.18.2002', 'name' => 'Bacem'],
                    ['code' => '35.05.18.2003', 'name' => 'Badsari'],
                    ['code' => '35.05.18.2004', 'name' => 'Candirejo'],
                    ['code' => '35.05.18.2005', 'name' => 'Dadaplangu'],
                    ['code' => '35.05.18.2006', 'name' => 'Gembongan'],
                    ['code' => '35.05.18.2007', 'name' => 'Jatilengger'],
                    ['code' => '35.05.18.2008', 'name' => 'Karanganyar'],
                    ['code' => '35.05.18.2009', 'name' => 'Kebonduren'],
                    ['code' => '35.05.18.2010', 'name' => 'Maliran'],
                    ['code' => '35.05.18.2011', 'name' => 'Pojok'],
                    ['code' => '35.05.18.2012', 'name' => 'Ringinanyar'],
                    ['code' => '35.05.18.2013', 'name' => 'Sidorejo'],
                ],
            ],
            [
                'code' => '35.05.19',
                'name' => 'Srengat',
                'villages' => [
                    ['code' => '35.05.19.1001', 'name' => 'Kelurahan Srengat'],
                    ['code' => '35.05.19.1002', 'name' => 'Kelurahan Dandong'],
                    ['code' => '35.05.19.1003', 'name' => 'Kelurahan Kauman'],
                    ['code' => '35.05.19.1004', 'name' => 'Kelurahan Togogan'],
                    ['code' => '35.05.19.2005', 'name' => 'Bagelenan'],
                    ['code' => '35.05.19.2006', 'name' => 'Dermojayan'],
                    ['code' => '35.05.19.2007', 'name' => 'Kandangan'],
                    ['code' => '35.05.19.2008', 'name' => 'Karanggayam'],
                    ['code' => '35.05.19.2009', 'name' => 'Kendalrejo'],
                    ['code' => '35.05.19.2010', 'name' => 'Maron'],
                    ['code' => '35.05.19.2011', 'name' => 'Ngaglik'],
                    ['code' => '35.05.19.2012', 'name' => 'Pakisrejo'],
                    ['code' => '35.05.19.2013', 'name' => 'Purwokerto'],
                    ['code' => '35.05.19.2014', 'name' => 'Selokajang'],
                    ['code' => '35.05.19.2015', 'name' => 'Wonorejo'],
                ],
            ],
            [
                'code' => '35.05.20',
                'name' => 'Wonodadi',
                'villages' => [
                    ['code' => '35.05.20.2001', 'name' => 'Wonodadi'],
                    ['code' => '35.05.20.2002', 'name' => 'Gandekan'],
                    ['code' => '35.05.20.2003', 'name' => 'Kolomayan'],
                    ['code' => '35.05.20.2004', 'name' => 'Kunir'],
                    ['code' => '35.05.20.2005', 'name' => 'Pikatan'],
                    ['code' => '35.05.20.2006', 'name' => 'Rejosari'],
                    ['code' => '35.05.20.2007', 'name' => 'Salam'],
                    ['code' => '35.05.20.2008', 'name' => 'Tawangrejo'],
                    ['code' => '35.05.20.2009', 'name' => 'Wonorejo'],
                ],
            ],
            [
                'code' => '35.05.21',
                'name' => 'Udanawu',
                'villages' => [
                    ['code' => '35.05.21.2001', 'name' => 'Bakung'],
                    ['code' => '35.05.21.2002', 'name' => 'Bendorejo'],
                    ['code' => '35.05.21.2003', 'name' => 'Besuki'],
                    ['code' => '35.05.21.2004', 'name' => 'Jati'],
                    ['code' => '35.05.21.2005', 'name' => 'Karanggondang'],
                    ['code' => '35.05.21.2006', 'name' => 'Ringinanom'],
                    ['code' => '35.05.21.2007', 'name' => 'Slemanan'],
                    ['code' => '35.05.21.2008', 'name' => 'Sukorejo'],
                    ['code' => '35.05.21.2009', 'name' => 'Sumbersari'],
                    ['code' => '35.05.21.2010', 'name' => 'Temenggungan'],
                ],
            ],
            [
                'code' => '35.05.22',
                'name' => 'Selorejo',
                'villages' => [
                    ['code' => '35.05.22.2001', 'name' => 'Selorejo'],
                    ['code' => '35.05.22.2002', 'name' => 'Ampelgading'],
                    ['code' => '35.05.22.2003', 'name' => 'Banjarsari'],
                    ['code' => '35.05.22.2004', 'name' => 'Boro'],
                    ['code' => '35.05.22.2005', 'name' => 'Ngreco'],
                    ['code' => '35.05.22.2006', 'name' => 'Olak-Alen'],
                    ['code' => '35.05.22.2007', 'name' => 'Pohgajih'],
                    ['code' => '35.05.22.2008', 'name' => 'Sidomulyo'],
                    ['code' => '35.05.22.2009', 'name' => 'Sumberagung'],
                ],
            ],
        ];

        foreach ($districts as $districtData) {
            $district = District::updateOrCreate(
                ['code' => $districtData['code']],
                ['name' => $districtData['name']]
            );

            foreach ($districtData['villages'] as $villageData) {
                Village::updateOrCreate(
                    ['code' => $villageData['code']],
                    [
                        'district_id' => $district->id,
                        'name' => $villageData['name'],
                    ]
                );
            }
        }
    }
}
