<?php if (empty($tarihler)): ?>

    <p><?= htmlspecialchars($il['il_adi']) ?> için bu filmde ileri tarihli seans bulunmuyor.</p>
    <p><a href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>&step=1">Şehir seçimine geri dön</a></p>

<?php else: ?>

    <h3>2. Adım: Tarih Seçin</h3>
    <p>Şehir: <?= htmlspecialchars($il['il_adi']) ?></p>

    <form method="get" action="bilet_al.php">
        <input type="hidden" name="film_id" value="<?= htmlspecialchars($film_id) ?>">
        <input type="hidden" name="il_id"   value="<?= htmlspecialchars($il_id) ?>">
        <input type="hidden" name="step"    value="3">

        <label>Tarih:</label><br>
        <input
            type="text"
            id="seans_tarihi"
            name="seans_tarihi"
            placeholder="Tarih seçin"
            required
            readonly
        >

        <br><br>
        <button type="submit">Devam Et</button>
    </form>

    <p>
        <a class="geri-btn" href="bilet_al.php?film_id=<?= htmlspecialchars($film_id) ?>&step=1">
            Şehir seçimine geri dön
        </a>
    </p>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const allowedDates = <?= json_encode($allowedDates) ?>;

        flatpickr("#seans_tarihi", {
            dateFormat: "Y-m-d",
            minDate: "today",
            enable: allowedDates
        });
    </script>

<?php endif; ?>
