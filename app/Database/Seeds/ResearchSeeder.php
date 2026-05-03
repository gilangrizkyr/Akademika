<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResearchSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Get some IDs
        $user = $db->table('users')->where('username', 'researcher')->get()->getRow();
        $categories = $db->table('categories')->get()->getResultArray();
        
        if (!$user || empty($categories)) {
            return;
        }

        $researchData = [
            [
                'title' => 'Penerapan AI dalam Deteksi Dini Kanker Paru',
                'slug' => 'penerapan-ai-deteksi-dini-kanker-paru',
                'abstract' => 'Penelitian ini mengeksplorasi penggunaan algoritma Deep Learning untuk menganalisis hasil CT scan dalam mendeteksi sel kanker tahap awal dengan akurasi tinggi.',
                'status' => 'published',
                'views' => 1250,
                'cover_image' => 'tech.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Dampak Pembelajaran Jarak Jauh terhadap Psikologi Siswa',
                'slug' => 'dampak-pjj-psikologi-siswa',
                'abstract' => 'Menganalisis tingkat stres dan efektivitas kognitif siswa selama masa pandemi COVID-19 melalui survei nasional di Indonesia.',
                'status' => 'published',
                'views' => 890,
                'cover_image' => 'edu.png',
                'category_id' => $categories[2]['id'], // Education
                'user_id' => $user->id,
            ],
            [
                'title' => 'Evolusi Blockchain dalam Sistem Logistik Global',
                'slug' => 'evolusi-blockchain-logistik-global',
                'abstract' => 'Bagaimana teknologi ledger terdistribusi dapat meningkatkan transparansi dan efisiensi dalam rantai pasok internasional.',
                'status' => 'published',
                'views' => 450,
                'cover_image' => 'tech.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Analisis Kualitas Air Sungai Ciliwung Pasca Restorasi',
                'slug' => 'analisis-kualitas-air-ciliwung',
                'abstract' => 'Studi lapangan mengenai dampak kebijakan restorasi sungai terhadap keanekaragaman hayati dan parameter kimia air.',
                'status' => 'published',
                'views' => 320,
                'cover_image' => 'env.png',
                'category_id' => $categories[1]['id'], // Health (Environment logic)
                'user_id' => $user->id,
            ],
            [
                'title' => 'Pengembangan Vaksin mRNA Generasi Terbaru',
                'slug' => 'pengembangan-vaksin-mrna-generasi-terbaru',
                'abstract' => 'Teknologi stabilisasi protein dalam vaksin mRNA untuk meningkatkan durasi perlindungan terhadap varian virus baru.',
                'status' => 'published',
                'views' => 2100,
                'cover_image' => 'health.png',
                'category_id' => $categories[1]['id'], // Health
                'user_id' => $user->id,
            ],
            [
                'title' => 'Implementasi Smart City di Jakarta Selatan',
                'slug' => 'implementasi-smart-city-jakarta-selatan',
                'abstract' => 'Evaluasi efektivitas sensor IoT dalam mengelola kemacetan dan sistem pembuangan sampah otomatis.',
                'status' => 'published',
                'views' => 560,
                'cover_image' => 'tech.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Metode Gamifikasi dalam Pembelajaran Matematika',
                'slug' => 'metode-gamifikasi-pembelajaran-matematika',
                'abstract' => 'Meningkatkan minat belajar siswa sekolah dasar menggunakan elemen permainan dalam kurikulum matematika digital.',
                'status' => 'published',
                'views' => 740,
                'cover_image' => 'edu.png',
                'category_id' => $categories[2]['id'], // Education
                'user_id' => $user->id,
            ],
            [
                'title' => 'Kesehatan Mental Pekerja Remote di Era Digital',
                'slug' => 'kesehatan-mental-pekerja-remote',
                'abstract' => 'Studi mengenai fenomena burnout dan isolasi sosial pada profesional yang bekerja sepenuhnya dari rumah.',
                'status' => 'published',
                'views' => 1100,
                'cover_image' => 'health.png',
                'category_id' => $categories[1]['id'], // Health
                'user_id' => $user->id,
            ],
            [
                'title' => 'Arsitektur Berkelanjutan dengan Material Bambu',
                'slug' => 'arsitektur-berkelanjutan-material-bambu',
                'abstract' => 'Penggunaan bambu laminasi sebagai pengganti baja ringan dalam konstruksi bangunan tahan gempa yang ramah lingkungan.',
                'status' => 'published',
                'views' => 230,
                'cover_image' => 'env.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Analisis Big Data untuk Prediksi Pergerakan Saham',
                'slug' => 'analisis-big-data-prediksi-saham',
                'abstract' => 'Menggunakan sentimen media sosial dan data historis untuk memodelkan volatilitas pasar modal Indonesia.',
                'status' => 'published',
                'views' => 1500,
                'cover_image' => 'tech.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Pemanfaatan Energi Surya pada Skala Rumah Tangga',
                'slug' => 'pemanfaatan-energi-surya-rumah-tangga',
                'abstract' => 'Analisis biaya-manfaat pemasangan panel surya atap dalam mengurangi tagihan listrik bulanan dan emisi karbon.',
                'status' => 'published',
                'views' => 480,
                'cover_image' => 'env.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Peran Literasi Digital dalam Melawan Hoaks Medis',
                'slug' => 'peran-literasi-digital-hoaks-medis',
                'abstract' => 'Strategi edukasi publik untuk memverifikasi informasi kesehatan yang beredar di platform WhatsApp dan Facebook.',
                'status' => 'published',
                'views' => 620,
                'cover_image' => 'edu.png',
                'category_id' => $categories[2]['id'], // Education
                'user_id' => $user->id,
            ],
            [
                'title' => 'Keamanan Data pada Jaringan 5G di Indonesia',
                'slug' => 'keamanan-data-jaringan-5g',
                'abstract' => 'Tantangan enkripsi dan privasi pengguna dalam transisi infrastruktur telekomunikasi ke standar 5G.',
                'status' => 'published',
                'views' => 390,
                'cover_image' => 'tech.png',
                'category_id' => $categories[0]['id'], // Technology
                'user_id' => $user->id,
            ],
            [
                'title' => 'Studi Nutrisi: Diet Intermittent Fasting untuk Obesitas',
                'slug' => 'studi-nutrisi-diet-intermittent-fasting',
                'abstract' => 'Efektivitas pengaturan jendela makan terhadap penurunan indeks massa tubuh dan profil lipid pada dewasa muda.',
                'status' => 'published',
                'views' => 1800,
                'cover_image' => 'health.png',
                'category_id' => $categories[1]['id'], // Health
                'user_id' => $user->id,
            ],
            [
                'title' => 'Inovasi EdTech: VR dalam Kelas Sejarah',
                'slug' => 'inovasi-edtech-vr-kelas-sejarah',
                'abstract' => 'Membawa siswa menjelajahi situs bersejarah secara virtual untuk meningkatkan retensi memori dan minat sejarah.',
                'status' => 'published',
                'views' => 510,
                'cover_image' => 'edu.png',
                'category_id' => $categories[2]['id'], // Education
                'user_id' => $user->id,
            ]
        ];

        foreach ($researchData as $r) {
            $r['created_at'] = date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'));
            $r['updated_at'] = $r['created_at'];
            
            $id = $db->table('researches')->insert($r);
            $researchId = $db->insertID();

            // Add professional sections for each research
            $sections = [
                [
                    'research_id' => $researchId,
                    'title' => 'Pendahuluan & Konteks Strategis',
                    'content' => '<p>Penelitian ini dilatarbelakangi oleh transformasi digital yang masif di berbagai sektor. Fokus utama studi ini adalah menganalisis integrasi sistem yang mampu beradaptasi dengan dinamika perubahan pasar global yang semakin fluktuatif.</p><p>Kami berupaya menjawab tantangan efisiensi operasional dengan mengusulkan model arsitektur baru yang menggabungkan prinsip-prinsip agilitas dan ketahanan data.</p>',
                    'image' => null,
                    'sort_order' => 1,
                ],
                [
                    'research_id' => $researchId,
                    'title' => 'Metodologi & Kerangka Analisis',
                    'content' => '<p>Metodologi yang digunakan adalah pendekatan kualitatif-eksploratif dengan menggunakan visualisasi alur proses yang ketat. Diagram di bawah ini merangkum langkah-langkah sistematis yang kami tempuh untuk memastikan validitas temuan.</p>',
                    'image' => 'chart2.png',
                    'sort_order' => 2,
                ],
                [
                    'research_id' => $researchId,
                    'title' => 'Temuan & Visualisasi Data',
                    'content' => '<p>Hasil analisis menunjukkan peningkatan efisiensi sebesar 35% pada tahap implementasi awal. Visualisasi grafik di bawah ini menggambarkan tren pertumbuhan yang konsisten selama periode pengamatan.</p>',
                    'image' => 'chart1.png',
                    'sort_order' => 3,
                ],
                [
                    'research_id' => $researchId,
                    'title' => 'Kesimpulan & Implikasi Kebijakan',
                    'content' => '<p>Kesimpulan dari penelitian ini menekankan pentingnya adopsi teknologi berbasis data untuk mendukung pengambilan keputusan strategis. Peta jangkauan di bawah ini menunjukkan potensi ekspansi model ini di masa depan.</p>',
                    'image' => 'chart3.png',
                    'sort_order' => 4,
                ]
            ];
            $db->table('research_sections')->insertBatch($sections);
        }
    }
}
