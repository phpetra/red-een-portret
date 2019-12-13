<div class="columns">
    <div class="column is-one-third">
        <a href="<?= $portrait['uri'] ?>" title="Naar de Red een portret website" id="<?= \PhPetra\Rep\Helper::determineSlug($person) ?>">
            <img src="<?= $portrait['image'] ?>" alt="Gered portret">
        </a>
        <div class="content">
            <?php foreach ($portrait['persons'] as $person): ?>
                <h2 class="is-size-4 is-marginless"> <?= \PhPetra\Rep\Helper::fullName($person) ?></h2>
            <?php endforeach ?>
        </div>
    </div>

    <div class="column">
        <a href="#top" class="is-pulled-right button js-trigger">&uarr;</a>
        <div class="columns is-multiline">
            <?php foreach ($portrait['stories'] as $story): ?>
                <div class="column is-half">
                    <div class="card">
                        <div class="card-content">
                            <p class="subtitle">
                                <?= $story['title'] ?>
                            </p>
                            <div class="content">
                                <?=$story['text']?>
                            </div>
                        </div>

                        <footer class="card-footer">
                            <p class="card-footer-item">
                          <span>
                              <strong><?= $story['user']?></strong>, op <?=$story['created']?>
                          </span>
                            </p>
                        </footer>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>