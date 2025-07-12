@startuml
    title Ecommerce Flow
    |Pembeli|
    start
    repeat
        :Mencari Produk yang diinginkan;
    repeat while (Add to cart?) is (no) not (yes)
    :Update Qty;
    :Check Out;
    :Pilih metode pengiriman;
    :Pilih metode pembayaran;
    |System|
    :Mengirimkan Notifikasi Pesanan;
    |#AntiqueWhite|Daya Karya|
    repeat
    :Verifikasi pembayaran;
    if(Pembayaran berhasil) then (yes)
    :Menyiapkan produk;
    :Mengirimkan pesanan menggunakan metode pengiriman;
    else (no)
    stop
    endif
    |System|
    :Update status Pesanan;
    if(Produk menggunakan ppn?) then (yes)
    :posting api accurate ppn;
    else (no)
    :posting api accurate non ppn;
    endif
    |Pembeli|
    :Pesanan diterima;
    stop
@enduml
