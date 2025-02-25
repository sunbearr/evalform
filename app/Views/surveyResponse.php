<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<main>
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4"><?= esc($survey['title']) ?></h2>
            <?php if (empty($questions)): ?>
                <h4 class="text-center">Empty Survey</h2>
            <?php else:?>
            <form method="post" action="<?= base_url('surveyResponse/' . esc($survey['survey_id'])) ?>">
                <div class="row">
                    <?php foreach ($questions as $question): ?>
                        <input type="hidden" name="question_ids[]" value="<?= esc($question['question_id']) ?>">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?= esc($question['question_text']) ?></h4>
                                    <?php if ($question['question_type'] == 'Free Text'): ?>
                                        <input type="text" name="texts[]" class="form-control" placeholder="Enter response" required>
                                    <?php endif; ?>

                                    <?php if ($question['question_type'] == 'MCQ'): ?>
                                        <select name="texts[]" class="form-control" required>
                                            <option value="">Select an option</option>
                                            <?php foreach ($options as $option): ?>
                                                <?php if ($option['question_id'] == $question['question_id']): ?>
                                                <option value="<?= esc($option['option_text']) ?>"><?= esc($option['option_text']) ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
