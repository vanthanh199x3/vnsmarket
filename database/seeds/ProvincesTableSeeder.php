<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('provinces')->delete();

        \DB::table('provinces')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Thành phố Hà Nội',
                'gso_id' => '01',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Tỉnh Hà Giang',
                'gso_id' => '02',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Tỉnh Cao Bằng',
                'gso_id' => '04',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Tỉnh Bắc Kạn',
                'gso_id' => '06',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Tỉnh Tuyên Quang',
                'gso_id' => '08',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Tỉnh Lào Cai',
                'gso_id' => '10',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Tỉnh Điện Biên',
                'gso_id' => '11',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Tỉnh Lai Châu',
                'gso_id' => '12',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Tỉnh Sơn La',
                'gso_id' => '14',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Tỉnh Yên Bái',
                'gso_id' => '15',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Tỉnh Hoà Bình',
                'gso_id' => '17',
                'created_at' => '2022-10-16 13:33:37',
                'updated_at' => '2022-10-16 13:33:37',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Tỉnh Thái Nguyên',
                'gso_id' => '19',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Tỉnh Lạng Sơn',
                'gso_id' => '20',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Tỉnh Quảng Ninh',
                'gso_id' => '22',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'Tỉnh Bắc Giang',
                'gso_id' => '24',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'Tỉnh Phú Thọ',
                'gso_id' => '25',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'Tỉnh Vĩnh Phúc',
                'gso_id' => '26',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'Tỉnh Bắc Ninh',
                'gso_id' => '27',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'Tỉnh Hải Dương',
                'gso_id' => '30',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'Thành phố Hải Phòng',
                'gso_id' => '31',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'Tỉnh Hưng Yên',
                'gso_id' => '33',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'Tỉnh Thái Bình',
                'gso_id' => '34',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'Tỉnh Hà Nam',
                'gso_id' => '35',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'Tỉnh Nam Định',
                'gso_id' => '36',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'Tỉnh Ninh Bình',
                'gso_id' => '37',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'Tỉnh Thanh Hóa',
                'gso_id' => '38',
                'created_at' => '2022-10-16 13:33:38',
                'updated_at' => '2022-10-16 13:33:38',
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'Tỉnh Nghệ An',
                'gso_id' => '40',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'Tỉnh Hà Tĩnh',
                'gso_id' => '42',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'Tỉnh Quảng Bình',
                'gso_id' => '44',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'Tỉnh Quảng Trị',
                'gso_id' => '45',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'Tỉnh Thừa Thiên Huế',
                'gso_id' => '46',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'Thành phố Đà Nẵng',
                'gso_id' => '48',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'Tỉnh Quảng Nam',
                'gso_id' => '49',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            33 =>
            array (
                'id' => 34,
                'name' => 'Tỉnh Quảng Ngãi',
                'gso_id' => '51',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            34 =>
            array (
                'id' => 35,
                'name' => 'Tỉnh Bình Định',
                'gso_id' => '52',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            35 =>
            array (
                'id' => 36,
                'name' => 'Tỉnh Phú Yên',
                'gso_id' => '54',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            36 =>
            array (
                'id' => 37,
                'name' => 'Tỉnh Khánh Hòa',
                'gso_id' => '56',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            37 =>
            array (
                'id' => 38,
                'name' => 'Tỉnh Ninh Thuận',
                'gso_id' => '58',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            38 =>
            array (
                'id' => 39,
                'name' => 'Tỉnh Bình Thuận',
                'gso_id' => '60',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            39 =>
            array (
                'id' => 40,
                'name' => 'Tỉnh Kon Tum',
                'gso_id' => '62',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            40 =>
            array (
                'id' => 41,
                'name' => 'Tỉnh Gia Lai',
                'gso_id' => '64',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            41 =>
            array (
                'id' => 42,
                'name' => 'Tỉnh Đắk Lắk',
                'gso_id' => '66',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            42 =>
            array (
                'id' => 43,
                'name' => 'Tỉnh Đắk Nông',
                'gso_id' => '67',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            43 =>
            array (
                'id' => 44,
                'name' => 'Tỉnh Lâm Đồng',
                'gso_id' => '68',
                'created_at' => '2022-10-16 13:33:39',
                'updated_at' => '2022-10-16 13:33:39',
            ),
            44 =>
            array (
                'id' => 45,
                'name' => 'Tỉnh Bình Phước',
                'gso_id' => '70',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            45 =>
            array (
                'id' => 46,
                'name' => 'Tỉnh Tây Ninh',
                'gso_id' => '72',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            46 =>
            array (
                'id' => 47,
                'name' => 'Tỉnh Bình Dương',
                'gso_id' => '74',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            47 =>
            array (
                'id' => 48,
                'name' => 'Tỉnh Đồng Nai',
                'gso_id' => '75',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            48 =>
            array (
                'id' => 49,
                'name' => 'Tỉnh Bà Rịa - Vũng Tàu',
                'gso_id' => '77',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            49 =>
            array (
                'id' => 50,
                'name' => 'Thành phố Hồ Chí Minh',
                'gso_id' => '79',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            50 =>
            array (
                'id' => 51,
                'name' => 'Tỉnh Long An',
                'gso_id' => '80',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            51 =>
            array (
                'id' => 52,
                'name' => 'Tỉnh Tiền Giang',
                'gso_id' => '82',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            52 =>
            array (
                'id' => 53,
                'name' => 'Tỉnh Bến Tre',
                'gso_id' => '83',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            53 =>
            array (
                'id' => 54,
                'name' => 'Tỉnh Trà Vinh',
                'gso_id' => '84',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            54 =>
            array (
                'id' => 55,
                'name' => 'Tỉnh Vĩnh Long',
                'gso_id' => '86',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            55 =>
            array (
                'id' => 56,
                'name' => 'Tỉnh Đồng Tháp',
                'gso_id' => '87',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            56 =>
            array (
                'id' => 57,
                'name' => 'Tỉnh An Giang',
                'gso_id' => '89',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            57 =>
            array (
                'id' => 58,
                'name' => 'Tỉnh Kiên Giang',
                'gso_id' => '91',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            58 =>
            array (
                'id' => 59,
                'name' => 'Thành phố Cần Thơ',
                'gso_id' => '92',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            59 =>
            array (
                'id' => 60,
                'name' => 'Tỉnh Hậu Giang',
                'gso_id' => '93',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            60 =>
            array (
                'id' => 61,
                'name' => 'Tỉnh Sóc Trăng',
                'gso_id' => '94',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            61 =>
            array (
                'id' => 62,
                'name' => 'Tỉnh Bạc Liêu',
                'gso_id' => '95',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
            62 =>
            array (
                'id' => 63,
                'name' => 'Tỉnh Cà Mau',
                'gso_id' => '96',
                'created_at' => '2022-10-16 13:33:40',
                'updated_at' => '2022-10-16 13:33:40',
            ),
        ));

    }
}
