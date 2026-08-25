# CV Portal

CV Portal, adayların profesyonel CV'ler oluşturabildiği, iş ilanlarını inceleyip başvuru yapabildiği; işverenlerin ise ilan oluşturup aday başvurularını yönetebildiği web tabanlı bir kariyer platformudur.

## Proje Özellikleri

### Aday

- Kayıt ve giriş
- Profil oluşturma ve düzenleme
- Eğitim bilgileri
- İş deneyimleri
- Yetenekler
- Birden fazla CV oluşturma
- Modern / Classic / Minimal CV şablonları
- CV önizleme
- PDF indirme
- Yazdırma
- Public / Private CV
- Paylaşılabilir CV bağlantısı
- QR kod
- İş ilanlarında arama
- İş ilanlarında filtreleme
- İş ilanlarına başvurma
- Favorilere ilan ekleme
- Başvuruları takip etme
- Bildirimleri görüntüleme

### İşveren

- Kayıt ve giriş
- Firma profili oluşturma
- Firma logosu yükleme
- Firma bilgilerini düzenleme
- İş ilanı oluşturma
- İş ilanı düzenleme
- İş ilanı silme
- İş ilanı durumu yönetme
- Gelen başvuruları görüntüleme
- Aday detaylarını inceleme
- Başvuru durumunu güncelleme
- Bildirimleri görüntüleme

### Admin

- Admin dashboard
- Kullanıcıları görüntüleme
- Kullanıcı silme
- Firmaları görüntüleme
- İş ilanlarını görüntüleme
- İlanları yayından kaldırma
- İlanları tekrar yayınlama
- İlan silme
- Başvuruları görüntüleme

## Kullanılan Teknolojiler

- Laravel 12
- PHP 8.2
- MySQL
- Blade
- HTML5
- CSS3
- JavaScript
- Vite
- Composer
- npm
- Laravel DomPDF
- QR Code API

## Kullanıcı Rolleri

Sistemde üç farklı kullanıcı rolü bulunmaktadır:

| Rol | Açıklama |
|---|---|
| Candidate | CV oluşturur, ilan arar ve başvuru yapar |
| Employer | Firma ve iş ilanlarını yönetir, başvuruları inceler |
| Admin | Sistemin genel yönetimini gerçekleştirir |

## Kurulum

Projeyi bilgisayarınıza indirdikten sonra proje klasörüne girin:

```bash
cd cv-portal