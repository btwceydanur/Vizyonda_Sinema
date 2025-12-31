<?php
// Bu dosya, $seans, $koltuk_kodlari, $bilet_detaylari, $bilet_tipleri,
// $is_carsamba, $saat_kampanya_var, $baz_fiyat, $toplam_tutar,
// $odeme_tipi, $kart_no, $kart_isim, $film_id, $seans_id, $salon_id,
// $il_id, $seans_tarihi_param gibi değişkenlere erişebiliyor (include sayesinde).
?>

<p class="onay-info">
    Film: <?= htmlspecialchars($seans['film_adi']) ?><br>
    Şehir: <?= htmlspecialchars($seans['il_adi']) ?><br>
    Salon: <?= htmlspecialchars($seans['salon_adi']) ?><br>
    Tarih: <?= htmlspecialchars($seans_tarihi) ?><br>
    Saat: <?= htmlspecialchars($seans_saati) ?><br>
    Baz fiyat (tek bilet): <?= htmlspecialchars($baz_fiyat) ?> TL
</p>

<form method="post" action="bilet_onayla.php">
    <input type="hidden" name="film_id"      value="<?= htmlspecialchars($film_id) ?>">
    <input type="hidden" name="seans_id"     value="<?= htmlspecialchars($seans_id) ?>">
    <input type="hidden" name="salon_id"     value="<?= htmlspecialchars($salon_id) ?>">
    <input type="hidden" name="il_id"        value="<?= htmlspecialchars($il_id) ?>">
    <input type="hidden" name="seans_tarihi" value="<?= htmlspecialchars($seans_tarihi_param) ?>">

    <?php foreach ($koltuk_kodlari as $kod): ?>
        <input type="hidden" name="koltuk_kodu[]" value="<?= htmlspecialchars($kod) ?>">
    <?php endforeach; ?>

    <table class="bilet-tablo">
        <thead>
            <tr>
                <th>Koltuk</th>
                <?php if (!$is_carsamba): ?>
                    <th>Bilet Tipi</th>
                <?php endif; ?>
                <th>Uygulanan Kampanya</th>
                <th>Fiyat (TL)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($koltuk_kodlari as $kod):
                $detay = $bilet_detaylari[$kod] ?? ['tip'=>null,'kampanya'=>'','fiyat'=>0];
                $secili_tip = $bilet_tipleri[$kod] ?? 'tam';
            ?>
                <tr>
                    <td><?= htmlspecialchars($kod) ?></td>

                    <?php if (!$is_carsamba): ?>
                        <td>
                            <label>
                                <input type="radio" name="bilet_tip[<?= htmlspecialchars($kod) ?>]" value="tam"
                                    <?= $secili_tip === 'tam' ? 'checked' : '' ?>>
                                Tam
                            </label>
                            <label>
                                <input type="radio" name="bilet_tip[<?= htmlspecialchars($kod) ?>]" value="ogrenci"
                                    <?= $secili_tip === 'ogrenci' ? 'checked' : '' ?>>
                                Öğrenci
                            </label>
                        </td>
                    <?php endif; ?>

                    <td data-kampanya="<?= htmlspecialchars($kod) ?>">
                        <?= htmlspecialchars($detay['kampanya']) ?>
                    </td>
                    <td data-fiyat="<?= htmlspecialchars($kod) ?>">
                        <?= htmlspecialchars(number_format($detay['fiyat'], 2)) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        Toplam Tutar:
        <strong id="toplam-tutar"><?= htmlspecialchars(number_format($toplam_tutar, 2)) ?> TL</strong>
    </p>

    <h3>Ödeme Tipi</h3>
    <?php $secili_odeme = $odeme_tipi; ?>
    <label>
        <input type="radio" name="odeme_tipi" value="nakit"
            <?= $secili_odeme === 'nakit' ? 'checked' : '' ?>>
        Nakit
    </label>
    <label>
        <input type="radio" name="odeme_tipi" value="kart"
            <?= $secili_odeme === 'kart' ? 'checked' : '' ?>>
        Kart
    </label>

    <div id="kart-bilgileri" class="kart-bilgileri">
        <h4>Kart Bilgileri</h4>
        <label>Kart Numarası (test için: 1234)</label><br>
        <input type="text" name="kart_no" value="<?= htmlspecialchars($kart_no) ?>"><br><br>

        <label>Kart Üzerindeki İsim</label><br>
        <input type="text" name="kart_isim" value="<?= htmlspecialchars($kart_isim) ?>"><br>
    </div>

    <br>
    <button type="submit" name="odeme_submit" value="1" class="btn_odeme">Ödemeyi Tamamla</button>
</form>

<p>
    <a class="geri-btn" href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>
        &step=4
        &il_id=<?= htmlspecialchars($il_id) ?>
        &seans_tarihi=<?= htmlspecialchars($seans_tarihi_param) ?>
        &seans_id=<?= htmlspecialchars($seans_id) ?>">
        Koltuk seçimine geri dön
    </a>
</p>

<script>
    const isCarsamba      = <?= $is_carsamba ? 'true' : 'false' ?>;
    const bazFiyat        = <?= json_encode($baz_fiyat) ?>;
    const saatKampanyaVar = <?= $saat_kampanya_var ? 'true' : 'false' ?>;

    function hesaplaSatir(koltukKod) {
        let tip = 'tam';

        if (!isCarsamba) {
            const radios = document.querySelectorAll(`input[name="bilet_tip[${koltukKod}]"]`);
            radios.forEach(r => {
                if (r.checked) tip = r.value;
            });
        }

        const kampanyaTd = document.querySelector(`td[data-kampanya="${koltukKod}"]`);
        const fiyatTd    = document.querySelector(`td[data-fiyat="${koltukKod}"]`);

        let kampanya = '';
        let fiyat    = 0;

        if (isCarsamba) {
            kampanya = 'Çarşamba kampanyası: Tüm biletler 120 TL (diğer kampanyalar geçerli değil)';
            fiyat    = 120;
        } else {
            if (tip === 'ogrenci') {
                kampanya = 'Öğrenci indirimi (%30)';
                fiyat    = bazFiyat * 0.7;
            } else { // tam
                if (saatKampanyaVar) {
                    kampanya = 'Özel seans indirimi (%20)';
                    fiyat    = bazFiyat * 0.8;
                } else {
                    kampanya = 'Kampanya yok';
                    fiyat    = bazFiyat;
                }
            }
        }

        if (kampanyaTd) kampanyaTd.textContent = kampanya;
        if (fiyatTd)    fiyatTd.textContent    = fiyat.toFixed(2);

        return fiyat;
    }

    function guncelleToplam() {
        let toplam = 0;
        <?php foreach ($koltuk_kodlari as $kod): ?>
            toplam += hesaplaSatir("<?= htmlspecialchars($kod, ENT_QUOTES) ?>");
        <?php endforeach; ?>
        const toplamEl = document.getElementById('toplam-tutar');
        if (toplamEl) {
            toplamEl.textContent = toplam.toFixed(2) + ' TL';
        }
    }

    if (!isCarsamba) {
        document.querySelectorAll('input[type="radio"][name^="bilet_tip["]').forEach(r => {
            r.addEventListener('change', guncelleToplam);
        });
    }

    guncelleToplam();

    const odemeRadios = document.querySelectorAll('input[name="odeme_tipi"]');
    const kartDiv = document.getElementById('kart-bilgileri');

    function guncelleKartGorunumu() {
        let secim = '';
        odemeRadios.forEach(r => {
            if (r.checked) secim = r.value;
        });
        if (secim === 'kart') {
            kartDiv.style.display = 'block';
        } else {
            kartDiv.style.display = 'none';
        }
    }

    odemeRadios.forEach(r => r.addEventListener('change', guncelleKartGorunumu));
    guncelleKartGorunumu();
</script>
