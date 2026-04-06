<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * Menampilkan daftar provinsi dari API Raja Ongkir
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data provinsi dari API Raja Ongkir
        $response = Http::withHeaders([

            //headers yang diperlukan untuk API Raja Ongkir
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),

        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        // Memeriksa apakah permintaan berhasil
        if ($response->successful()) {

            // Mengambil data provinsi dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            $provinces = $response->json()['data'] ?? [];
        }

        // returning the view with provinces data
        return view('rajaongkir', compact('provinces'));
    }

    /**
     * Mengambil data kota berdasarkan ID provinsi
     *
     * @param int $provinceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities($provinceId)
    {
        $cacheKey = "rajaongkir_cities_{$provinceId}";
        $cities = [];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

            if ($response->successful()) {
                $cities = $response->json()['data'] ?? [];
                // Cache successful response for 1 hour
                \Illuminate\Support\Facades\Cache::put($cacheKey, $cities, 3600);
            } else {
                \Illuminate\Support\Facades\Log::warning('Cities API failed:', ['status' => $response->status(), 'province_id' => $provinceId]);
                // Use cached data or fallback
                $cities = \Illuminate\Support\Facades\Cache::get($cacheKey, $this->getFallbackCities($provinceId));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to fetch cities: ' . $e->getMessage());
            // Use cached data or fallback
            $cities = \Illuminate\Support\Facades\Cache::get($cacheKey, $this->getFallbackCities($provinceId));
        }

        return response()->json($cities);
    }

    /**
     * Mengambil data kecamatan berdasarkan ID kota
     *
     * @param int $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($cityId)
    {
        $cacheKey = "rajaongkir_districts_{$cityId}";
        $districts = [];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

            if ($response->successful()) {
                $districts = $response->json()['data'] ?? [];
                // Cache successful response for 1 hour
                \Illuminate\Support\Facades\Cache::put($cacheKey, $districts, 3600);
            } else {
                \Illuminate\Support\Facades\Log::warning('Districts API failed:', ['status' => $response->status(), 'city_id' => $cityId]);
                // Use cached data or fallback
                $districts = \Illuminate\Support\Facades\Cache::get($cacheKey, $this->getFallbackDistricts($cityId));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to fetch districts: ' . $e->getMessage());
            // Use cached data or fallback
            $districts = \Illuminate\Support\Facades\Cache::get($cacheKey, $this->getFallbackDistricts($cityId));
        }

        return response()->json($districts);
    }

    /**
     * Menghitung ongkos kirim berdasarkan data yang diberikan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()->withHeaders([

            //headers yang diperlukan untuk API Raja Ongkir
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),

        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin'      => $request->input('origin', 3855), // ID kecamatan asal (default Diwek)
                'destination' => $request->input('destination'), // ID kecamatan tujuan
                'weight'      => $request->input('weight'), // Berat dalam gram
                'courier'     => $request->input('courier'), // Kode kurir (jne, tiki, pos)
        ]);

        if ($response->successful()) {

            // Mengambil data ongkos kirim dari respons JSON
            // Jika 'rajaongkir.results' tidak ada, inisialisasi dengan array kosong
            return response()->json($response->json()['rajaongkir']['results'] ?? []);
        }

        return response()->json(['error' => 'Failed to get shipping cost'], 400);
    }

    /**
     * Get fallback cities data when API is not available
     */
    private function getFallbackCities($provinceId)
    {
        // Return some sample cities based on province ID
        // In a real application, you might want to have a more comprehensive fallback database
        $fallbackCities = [
            11 => [ // DKI Jakarta
                ['id' => 151, 'name' => 'JAKARTA BARAT', 'postal_code' => '11200'],
                ['id' => 152, 'name' => 'JAKARTA PUSAT', 'postal_code' => '10110'],
                ['id' => 153, 'name' => 'JAKARTA SELATAN', 'postal_code' => '12190'],
                ['id' => 154, 'name' => 'JAKARTA TIMUR', 'postal_code' => '13330'],
                ['id' => 155, 'name' => 'JAKARTA UTARA', 'postal_code' => '14140'],
            ],
            12 => [ // Jawa Barat
                ['id' => 23, 'name' => 'BANDUNG', 'postal_code' => '40111'],
                ['id' => 63, 'name' => 'BEKASI', 'postal_code' => '17111'],
                ['id' => 106, 'name' => 'BOGOR', 'postal_code' => '16111'],
                ['id' => 107, 'name' => 'CIANJUR', 'postal_code' => '43211'],
                ['id' => 198, 'name' => 'DEPOK', 'postal_code' => '16411'],
            ],
            13 => [ // Jawa Tengah
                ['id' => 399, 'name' => 'SEMARANG', 'postal_code' => '50211'],
                ['id' => 420, 'name' => 'SURAKARTA', 'postal_code' => '57111'],
                ['id' => 419, 'name' => 'SURABAYA', 'postal_code' => '60211'],
                ['id' => 377, 'name' => 'PEKALONGAN', 'postal_code' => '51111'],
                ['id' => 378, 'name' => 'PURWOKERTO', 'postal_code' => '53111'],
            ],
        ];

        return $fallbackCities[$provinceId] ?? [
            ['id' => 1, 'name' => 'KOTA UTAMA', 'postal_code' => '00000'],
            ['id' => 2, 'name' => 'KOTA KEDUA', 'postal_code' => '00000'],
        ];
    }

    private function getFallbackDistricts($cityId)
    {
        // Return some sample districts
        // In a real application, you might want to have a more comprehensive fallback database
        return [
            ['id' => 1, 'name' => 'KECAMATAN UTAMA'],
            ['id' => 2, 'name' => 'KECAMATAN KEDUA'],
            ['id' => 3, 'name' => 'KECAMATAN KETIGA'],
            ['id' => 4, 'name' => 'KECAMATAN KEEMPAT'],
            ['id' => 5, 'name' => 'KECAMATAN KELIMA'],
        ];
    }
}
