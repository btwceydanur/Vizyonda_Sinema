<?php if (empty($seanslar)): ?>

    <p>
        <?= htmlspecialchars($il['il_adi']) ?> şehrinde,
        <?= htmlspecialchars($seans_tarihi) ?> tarihinde bu film için uygun (geçmemiş) seans bulunmuyor.
    </p>
    <p>
        <a href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>&step=2&il_id=<?= htmlspecialchars($il_id) ?>">
            Tarih seçimine geri dön
        </a>
    </p>

<?php else: ?>

    <h3>3. Adım: Seans Seçin</h3>
    <p>Şehir: <?= htmlspecialchars($il['il_adi']) ?></p>
    <p>Tarih: <?= htmlspecialchars($seans_tarihi) ?></p>

    <form method="get" action="bilet_al.php">
        <input type="hidden" name="film_id"       value="<?= htmlspecialchars($film_id) ?>">
        <input type="hidden" name="il_id"         value="<?= htmlspecialchars($il_id) ?>">
        <input type="hidden" name="seans_tarihi"  value="<?= htmlspecialchars($seans_tarihi) ?>">
        <input type="hidden" name="step"          value="4">

        <?php foreach ($seanslar as $s): ?>
            <div style="margin-bottom:8px;">
                <label>
                    <input type="radio" name="seans_id" value="<?= htmlspecialchars($s['seans_id']) ?>" required>
                    Saat: <?= htmlspecialchars($s['seans_saati']) ?> |
                    Salon: <?= htmlspecialchars($s['salon_adi']) ?> |
                    Baz Fiyat: <?= htmlspecialchars($s['baz_fiyat']) ?> TL
                </label>
            </div>
        <?php endforeach; ?>

        <br>
        <button type="submit">Devam Et</button>
    </form>

    <p>
        <a class="geri-btn" href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>&step=2&il_id=<?= htmlspecialchars($il_id) ?>">
            Tarih seçimine geri dön
        </a>
    </p>

<?php endif; ?>
