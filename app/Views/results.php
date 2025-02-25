<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <main>
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-4"><?= esc($survey['title']) ?> Results</h2>
                <div class="row">
                <?php if (empty($questions)): ?>
                    <div class="col-12 mb-4">
                        <p>No questions found for this survey.</p>
                    </div>
                <?php else: ?>
                    <div class="col-12 mb-4"">
                        <!-- This assumes every question is mandatory to answer. -->
                        <p>Total Responses: <?= esc(count($responses)) / esc(count($questions)) ?> </p>
                    </div>
                    <div class="col-12 mb-4">
                      <?php foreach ($questions as $index => $question): ?>
                          <div class="card">
                              <div class="card-body">
                                  <div class="row">
                                      <div class="col-md-8">
                                          <h4 class="card-title">Question <?= $index + 1 ?> : <?= esc($question['question_type'])?></h4>
                                          <p class="card-text"><?= esc($question['question_text']) ?></p>
                                      
                                          <?php if (esc($question['question_type']) === "Free Text"): ?>
                                            <div class="position-absolute top-0 end-0 px-1">
                                                <a href="<?= base_url('surveys/' . $survey['user_id'] .'/results/'.$survey['survey_id']."/".$question['question_id']);?>" class="me-2 btn btn-outline-dark"><i class="bi bi-list" style="font-size:1.5rem;"></i> List of Responses</a>
                                                <a href="<?= base_url('surveys/' . $survey['user_id'] . '/results/'.$survey['survey_id']."/".$question['question_id'])."/AIsummary";?>" class="me-2 btn btn-outline-success"><i class="bi bi-robot" style="font-size:1.5rem;"></i> AI Summary</a>
                                            </div>
                                          <?php endif; ?>

                                          <?php if (esc($question['question_type']) === "MCQ"): ?>
                                              <?php foreach (esc($options) as $index => $option): ?>
                                                  <?php if (esc($question['question_id']) === esc($option['question_id'])): ?>
                                                      <p class="card-text"><?= $option['option_text'] ?> : <?= $option['percentage'] ?>%</p>
                                                  <?php endif; ?>
                                              <?php endforeach; ?>
                                          <?php endif; ?>
                                      </div>
                                      <div class="col-md-4">
                                          <?php if (esc($question['question_type']) === "MCQ"): ?>
                                              <canvas id="chart_<?= esc($question['question_id']) ?>_mcq" width="400" height="400"></canvas>
                                              <script>
                                                    <?php if (esc($question['question_type']) === "MCQ"): ?>
                                                        var canvasId = 'chart_<?= esc($question['question_id']) ?>_mcq';
                                                        var canvas = document.getElementById(canvasId);
                                                        if (canvas) {
                                                            var ctx = canvas.getContext('2d');
                                                            var chart = new Chart(ctx, {
                                                                type: 'pie',
                                                                data: {
                                                                    labels: [
                                                                        <?php foreach ($options as $option): ?>
                                                                            <?php if ($option['question_id'] === $question['question_id']): ?>
                                                                                '<?= esc($option['option_text']) ?>',
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    ],
                                                                    datasets: [{
                                                                        label: '<?= esc($question['question_text']) ?>',
                                                                        data: [
                                                                            <?php foreach ($options as $option): ?>
                                                                                <?php if ($option['question_id'] === $question['question_id']): ?>
                                                                                    <?= $option['count'] ?>,
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        ],
                                                                        backgroundColor: [
                                                                            'rgba(255, 99, 132, 0.5)',
                                                                            'rgba(54, 162, 235, 0.5)',
                                                                            'rgba(255, 206, 86, 0.5)',
                                                                            'rgba(75, 192, 192, 0.5)',
                                                                            'rgba(153, 102, 255, 0.5)',
                                                                            'rgba(255, 159, 64, 0.5)'
                                                                        ],
                                                                        borderColor: [
                                                                            'rgba(255, 99, 132, 1)',
                                                                            'rgba(54, 162, 235, 1)',
                                                                            'rgba(255, 206, 86, 1)',
                                                                            'rgba(75, 192, 192, 1)',
                                                                            'rgba(153, 102, 255, 1)',
                                                                            'rgba(255, 159, 64, 1)'
                                                                        ],
                                                                        borderWidth: 1
                                                                    }]
                                                                },
                                                                options: {
                                                                    responsive: true
                                                                }
                                                            });
                                                        } else {
                                                            console.error('Canvas with id "' + canvasId + '" not found');
                                                        }
                                                    <?php endif; ?>
                                                
                                            </script>

                                          <?php endif; ?>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
            </div>
      </main>
    
<?= $this->endSection() ?>