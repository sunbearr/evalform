<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<main>
    <section class="py-5">
        <div class="container">

            <h2 class="text-center mb-4">Responses to <?=esc($question['question_text'])?></h2>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    
                        <p><?=esc($returned_summary)?> </p>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    
      <?= $this->endSection() ?>