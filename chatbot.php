<?php
// diperlukan header
header(" Kontrol-Akses-Izinkan-Asal: * ");
header(" Tipe-Konten: aplikasi/json; charset=UTF-8 ");
header(" Kontrol-Akses-Izinkan-Metode: POST ");
header(" Kontrol-Akses-Usia-Maks: 3600 ");
header(" Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With ");

// tambahkan file php ini ke server web Anda dan masukkan url lengkap di AutoResponder (mis. https://www.example.com/api_autoresponder.php)

// untuk mengizinkan hanya permintaan resmi, Anda perlu mengonfigurasi file .htaccess Anda dan menyetel kredensial dengan opsi Otorisasi Dasar di AutoResponder

// mengakses tajuk khusus yang ditambahkan dalam aturan AutoResponder Anda
// ganti XXXXXX_XXXX dengan nama header dalam UPPERCASE (dan dengan '-' diganti dengan '_')
$ myheader = $ _SERVER [ 'HTTP_MATCHBOX_XXXXSERVER' ];
  
// dapatkan data yang diposting
$ data = json_decode(file_get_contents(" php://input "));
  
// pastikan data json tidak lengkap
jika (
	!kosong( $ data -> kueri ) &&
	!kosong( $ data -> appPackageName ) &&
	!kosong( $ data -> messengerPackageName ) &&
	!kosong( $ data -> kueri -> pengirim ) &&
	!kosong( $ data -> kueri -> pesan )
){
	
	// nama paket AutoResponder untuk mendeteksi dari AutoResponder mana pesan itu berasal
	$ appPackageName = $ data -> appPackageName ;
	// nama paket messenger untuk mendeteksi dari messenger mana pesan itu berasal
	$ messengerPackageName = $ data -> messengerPackageName ;
	// nama/nomor pengirim pesan (seperti yang ditampilkan di notifikasi Android)
	$ pengirim = $ data -> kueri -> pengirim ;
	// teks pesan masuk
	$ pesan = $ data -> kueri -> pesan ;
	// apakah pengirimnya adalah grup? benar atau salah
	$ isGroup = $ data -> kueri -> isGroup ;
	// nama/nomor peserta grup yang mengirim pesan jika dikirim dalam grup, jika tidak kosong
	$ groupParticipant = $ data -> query -> groupParticipant ;
	// id dari aturan AutoResponder yang telah mengirim permintaan server web
	$ ruleId = $ data -> permintaan -> ruleId ;
	// apakah ini pesan percobaan dari AutoResponder? benar atau salah
	$ isTestMessage = $ data -> kueri -> isTestMessage ;
	
	
	
	// proses pesan di sini
	
	
	
	// atur kode respons - 200 sukses
	http_response_code( 200 );

	// kirim satu atau beberapa balasan ke AutoResponder
	echo json_encode( array (" balasan " => array (
		array (" pesan " => " Hai " . $ pengirim . " ! \n Terima kasih telah mengirimkan: " . $ pesan ),
		array (" pesan " => " Sukses ✅ ")
	)));
	
	// atau ini sebagai gantinya tanpa balasan:
	// echo json_encode(array("balasan" => array()));
}

// beri tahu pengguna bahwa data json tidak lengkap
lain {
	
	// atur kode respons - 400 permintaan buruk
	http_response_code( 400 );
	
	// kirim kesalahan
	echo json_encode( array (" balasan " => array (
		larik (" pesan " => " Kesalahan ❌ "),
		array (" pesan " => " Data JSON tidak lengkap. Apakah permintaan dikirim oleh AutoResponder? ")
	)));
}
?>
