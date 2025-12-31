<?php if (empty($iller)): ?>

    <p>Bu film için tanımlı seans bulunmuyor.</p>
    <p><a href="ilk_orn.php">Ana sayfaya dön</a></p>

<?php else: ?>

    <h3>1. Adım: Şehir Seçin</h3>

    <form method="get" action="bilet_al.php">
        <input type="hidden" name="film_id" value="<?= htmlspecialchars($film_id) ?>">
        <input type="hidden" name="step" value="2">

        <label>Şehir:</label><br>
        <select name="il_id" required>
            <option value="">Seçiniz</option>
            <?php foreach ($iller as $ilRow): ?>
                <option value="<?= htmlspecialchars($ilRow['il_id']) ?>">
                    <?= htmlspecialchars($ilRow['il_adi']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <button type="submit">Devam Et</button>
    </form>

    <p><a class="geri-btn" href="ilk_orn.php">İptal et ve ana sayfaya dön</a></p>

<?php endif; ?>
