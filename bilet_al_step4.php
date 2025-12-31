<h3>4. Adım: Koltuk Seçin</h3>

<p>
    Şehir: <?= htmlspecialchars($seans['il_adi']) ?><br>
    Salon: <?= htmlspecialchars($seans['salon_adi']) ?><br>
    Tarih: <?= htmlspecialchars($seans['seans_tarihi']) ?><br>
    Saat: <?= htmlspecialchars($seans['seans_saati']) ?><br>
    Baz Fiyat (tek bilet): <?= htmlspecialchars($seans['baz_fiyat']) ?> TL
</p>

<?php if (empty($koltuklar)): ?>

    <p>Bu salonda tanımlı koltuk bulunmuyor.</p>

<?php else: ?>

    <div class="perde">PERDE</div>

    <form method="post" action="bilet_onayla.php">
        <input type="hidden" name="film_id"      value="<?= htmlspecialchars($film_id) ?>">
        <input type="hidden" name="seans_id"     value="<?= htmlspecialchars($seans['seans_id']) ?>">
        <input type="hidden" name="salon_id"     value="<?= htmlspecialchars($seans['salon_id']) ?>">
        <input type="hidden" name="il_id"        value="<?= htmlspecialchars($il_id) ?>">
        <input type="hidden" name="seans_tarihi" value="<?= htmlspecialchars($seans['seans_tarihi']) ?>">

        <div class="koltuk-salon">
            <?php
            $sonSira = null;
            foreach ($koltuklar as $k) {
                $sira   = $k['sira'];
                $numara = $k['numara'];
                $kod    = $k['koltuk_kodu'];
                $dolu   = in_array($kod, $doluKoltuklar, true);

                if ($sonSira !== $sira) {
                    if ($sonSira !== null) {
                        echo '</div>'; 
                    }
                    echo '<div class="koltuk-satir">';
                    echo htmlspecialchars($sira) . ' ';
                    $sonSira = $sira;
                }

                $class = $dolu ? 'koltuk-kare koltuk-dolu' : 'koltuk-kare koltuk-bos';

                if ($dolu) {
                    echo '<label class="' . $class . '">';
                    echo htmlspecialchars($kod);
                    echo '</label>';
                } else {
                    echo '<label class="' . $class . '">';
                    echo '<input type="checkbox" name="koltuk_kodu[]" value="' . htmlspecialchars($kod) . '"> ';
                    echo htmlspecialchars($kod);
                    echo '</label>';
                }
            }
            if ($sonSira !== null) {
                echo '</div>'; 
            }
            ?>
        </div>

        <br>
        <p>Bir veya birden fazla koltuk seçebilirsiniz.</p>
        <button type="submit" name="islem" value="secim">Devam Et</button>
    </form>

    <p>
        <a class="geri-btn" href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>&step=3&il_id=<?= htmlspecialchars($il_id) ?>&seans_tarihi=<?= htmlspecialchars($seans_tarihi) ?>">
            Seans seçimine geri dön
        </a>
    </p>

<?php endif; ?>
