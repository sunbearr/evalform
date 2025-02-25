<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4"><?= isset($survey) ? 'Edit Survey' : 'Create Survey' ?></h2>
                <form method="post" action="<?= base_url('surveys/' . $user['user_id'] . '/addeditSurvey' . (isset($survey) ? '/' . $survey['survey_id'] : '')) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="title" class="form-label">Survey Title</label>
                        <input type="title" class="form-control" id="title" name="title" value="<?= isset($survey) ? esc($survey['title']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Survey Description</label>
                        <input type="title" class="form-control" id="description" name="description" value="<?= isset($survey) ? esc($survey['description']) : '' ?>" required>
                    </div>



                    <!-- Container for dynamically added questions -->
                    <div id="questionsContainer" class="mt-4">
                        <?php if (isset($survey) && !empty($questions)): ?>
                            <?php foreach ($questions as $question): ?>
                                <input type="hidden" name="question_types[]" value="<?= $question['question_type'] ?>">
                                <input type="hidden" name="question_ids[]" value="<?= $question['question_id'] ?>">
                                <div class="card mb-3">
                                    <div class="card-body">
                                    <a href="#" class="btn btn-danger btn-sm float-end delete-question" data-question-id="<?= $question['question_id'] ?>"><i class="bi bi-trash"></i></a>
                                        <label for="question" class="form-label">Question</label>
                                        <input type="text" class="form-control" name="questions[]" value="<?= esc($question['question_text']) ?>" placeholder="Enter your question">
                                        
                                        <?php if (!empty($options && ($question['question_type'] == 'MCQ'))): ?>
                                            <label for="options" class="form-label">Options</label>
                                            <div class="mcq-options">
                                                <?php foreach ($options as $option): ?>
                                                    <?php if (($option['question_id'] == $question['question_id'])): ?>
                                                        <div class="input-group mb-2">
                                                            <input type="text" class="form-control" name="mcq_options[<?= $question['question_id'] ?>][]" value="<?= esc($option['option_text']) ?>" placeholder="Enter option">
                                                            <button type="button" class="btn btn-danger delete-option"><i class="bi bi-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm add-option">Add Option</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Dropdown button for adding different types of questions -->
                    <div class="dropdown mb-3">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Add Question
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-type="Free Text">Free Text</a></li>
                            <li><a class="dropdown-item" href="#" data-type="mcq">Multiple Choice</a></li>
                        </ul>
                    </div>
                    <div id="questionsContainer"></div>


                    <button type="submit" class="btn btn-primary"><?= isset($survey) ? 'Update Survey' : 'Create Survey' ?></button>
                </form>
            </div>
        </div>
    </div>

<!-- Hidden templates for question cards -->
<div id="textQuestionTemplate" style="display: none;">
    <div class="card mb-3">
        <div class="card-body">
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" name="questions[]" placeholder="Enter your question">
            <input type="hidden" name="question_types[]" value="<?= 'Free Text' ?>">
            <a href="#" class="btn btn-danger btn-sm float-end delete-question"><i class="bi bi-trash"></i></a>
        </div>
    </div>
</div>

<div id="mcqQuestionTemplate" style="display: none;">
    <div class="card mb-3">
        <div class="card-body">
            <a href="#" class="btn btn-danger btn-sm float-end delete-question"><i class="bi bi-trash"></i></a>
            <label for="question" class="form-label">Question</label>
            <input type="text" class="form-control" name="questions[]" placeholder="Enter your question">
            <input type="hidden" name="question_types[]" value="MCQ">
            <label for="options" class="form-label">Options</label>
            <div class="mcq-options">
                <!-- Options will be added here dynamically -->
            </div>
            <button type="button" class="btn btn-primary btn-sm add-option">Add Option</button>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var questionsContainer = document.getElementById('questionsContainer');

    var dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            var questionType = event.target.dataset.type;
            addQuestion(questionType);
        });
    });

    questionsContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-question')) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this question?')) {
                event.target.closest('.card').remove();
            }
        }

        if (event.target.classList.contains('delete-option')) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this option?')) {
                event.target.closest('.input-group').remove();
            }
        }
    });

    function addQuestion(type) {
        var questionTemplate;
        if (type === 'mcq') {
            questionTemplate = document.getElementById('mcqQuestionTemplate');
        } else if (type === 'Free Text') {
            questionTemplate = document.getElementById('textQuestionTemplate');
        }

        if (questionTemplate) {
            var questionClone = questionTemplate.cloneNode(true); // Clone the template
            questionClone.style.display = ''; // Make the clone visible
            questionClone.dataset.questionId = generateUniqueId(); // Assign a unique ID

            // Clear any pre-filled options from the template
            var optionsContainer = questionClone.querySelector('.mcq-options');
            if (optionsContainer) {
                optionsContainer.innerHTML = '';
            }

            questionsContainer.appendChild(questionClone); // Append the clone to the questions container

            // Add event listener for delete button of the cloned question
            questionClone.querySelector('.delete-question').addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this question?')) {
                    questionClone.remove();
                }
            });

            // Add event listener for the add option button of the cloned question (only for MCQ)
            if (type === 'mcq') {
                questionClone.querySelector('.add-option').addEventListener('click', function(event) {
                    event.preventDefault();
                    var questionId = questionClone.dataset.questionId;
                    var optionTemplate = document.createElement('div');
                    optionTemplate.className = 'input-group mb-2';
                    optionTemplate.innerHTML = '<input type="text" class="form-control" name="mcq_options[' + questionId + '][]" placeholder="Enter option"><button type="button" class="btn btn-danger delete-option"><i class="bi bi-trash"></i></button>';
                    optionsContainer.appendChild(optionTemplate);
                    
                    // Add event listener for the delete option button
                    optionTemplate.querySelector('.delete-option').addEventListener('click', function(event) {
                        event.preventDefault();
                        if (confirm('Are you sure you want to delete this option?')) {
                            optionTemplate.remove();
                        }
                    });
                });
            }
        }
    }

    function generateUniqueId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
    }

    // Add event listener for existing questions' delete buttons
    var existingQuestions = questionsContainer.querySelectorAll('.delete-question');
    existingQuestions.forEach(function(deleteButton) {
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation(); // Stop event propagation
            if (confirm('Are you sure you want to delete this question?')) {
                var deletedQuestion = deleteButton.closest('.card');
                var deletedQuestionId = deleteButton.dataset.questionId; // Get the question_id of the deleted question

                // Remove the corresponding question_id from the question_ids array
                var questionIdsInputs = questionsContainer.querySelectorAll('input[name="question_ids[]"]');
                questionIdsInputs.forEach(function(input) {
                    if (input.value === deletedQuestionId) {
                        input.remove(); // Remove the input field with the matching question_id
                    }
                });

                deletedQuestion.remove(); // Remove the deleted question card
            }
        });
    });

        // Add event listener for "Add Option" button
    var addOptionButtons = document.querySelectorAll('.add-option');
    addOptionButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var questionCard = event.target.closest('.card');
            var optionsContainer = questionCard.querySelector('.mcq-options');
            var questionId = questionCard.dataset.questionId;
            var optionTemplate = document.createElement('div');
            optionTemplate.className = 'input-group mb-2';
            optionTemplate.innerHTML = '<input type="text" class="form-control" name="mcq_options[' + questionId + '][]" placeholder="Enter option"><a href="#" class="btn btn-danger delete-option"><i class="bi bi-trash"></i></a>';
            optionsContainer.appendChild(optionTemplate);

            // Add event listener for the delete option button
            optionTemplate.querySelector('.delete-option').addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this option?')) {
                    optionTemplate.remove();
                }
            });
        });
    });

    
});

</script>




</section>

<?= $this->endSection() ?>
