<?php namespace App\Controllers;

use CodeIgniter\Controller;

class SurveyController extends BaseController
{
    public function __construct()
 {
     
     helper('url'); 
     $this->session = session();
 }

    /**
 * Controller method for displaying the a provided user's list of surveys
 * 
 * @param int $user_id The id of the user the surveys belong to.
 * 
 * @return View The view displaying the list of the user's surveys.
 */
public function surveys($user_id)
{
        $userModel = new \App\Models\UserModel();
        $surveyModel = new \App\Models\SurveyModel();

        // Fetch user details by user_id
        $data['user'] = $userModel->find($user_id);
        
        // Ensure user exists
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User Not Found');
        }

        // Fetch user's survey data
        $data['surveys'] = $surveyModel->where('user_id', $user_id)->findAll();

        return view('surveys', $data);
}

/**
 * Controller method for handling the survey response page, allowing users to answer
 * free text and MCQs and submit the responses.
 * 
 * @param int $survey_id The ID of the survey being answered.
 * 
 * @return View The view displaying the survey response page.
 */
public function surveyResponse($survey_id)
{
    $surveyModel = new \App\Models\SurveyModel();
    $questionModel = new \App\Models\QuestionModel();
    $optionModel = new \App\Models\OptionModel();

    $responseModel = new \App\Models\ResponseModel();
    
    // If the user is submitting the completed survey, update our response table with
    // the new response data.
    if ($this->request->getMethod() === 'POST') {
        $questionIDs = $this->request->getPost("question_ids");
        $texts = $this->request->getPost("texts");

        $ResponseData = [];

        // Turn array from [q1, q2, q3, ...] to [[q1], [q2], [q3],...]
        foreach ($questionIDs as $index => $questionID) {
            // Add both question ID and corresponding text to the response data array
            $ResponseData[] = [
                'question_id' => $questionID,
                'text' => $texts[$index]
            ];
        }

        if ($responseModel->insertBatch($ResponseData)) {
            // If the user is successfully added, set a success message.
            $this->session->setFlashdata('success', 'User added successfully.');
        } else {
            // If the addition fails, set an error message.
            $this->session->setFlashdata('error', 'Failed to add user. Please try again.');
        }

        return redirect()->to('/'); // return to landing page
    }

    // handle displaying the survey response view if not submitting.
       
    $data['survey'] = $surveyModel->find($survey_id);
        
    // check survey exists
    if (!$data['survey']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Survey Not Found');
    }

    // Fetch related data
    $data['questions'] = $questionModel->where('survey_id', $survey_id)->findAll();

    // Initialize an array to store options
    $data['options'] = [];

    // Fetch options for each question
    foreach ($data['questions'] as $question) {
        $options = $optionModel->where('question_id', $question['question_id'])->findAll();
        // Merge options into the options array
        $data['options'] = array_merge($data['options'], $options);
    }

    return view('surveyResponse', $data);

}

   /**
 * Controller method for adding/editing surveys. Populates survey, question, and option data.
 * 
 * @param int $user_id The id of the user the survey belongs to.
 * @param int $survey_id The id survey to be edited. If null, the survey is being newly created.
 * 
 * @return View The view displaying the survey creation page (if controller receives get request).
 *              If controller receives post request, return redirect back to landing page after
 *              performing database updates.
 */
public function addeditSurvey($user_id, $survey_id = null)
{
    $userModel = new \App\Models\UserModel();
    $surveyModel = new \App\Models\SurveyModel();
    $questionModel = new \App\Models\QuestionModel();
    $optionModel = new \App\Models\OptionModel();

    if ($this->request->getMethod() === 'POST') {
        // Retrieve the submitted form data.
        $title = $this->request->getPost("title");
        $description = $this->request->getPost("description");
        $questions = $this->request->getPost("questions");
        $question_types = $this->request->getPost("question_types");
        $options = $this->request->getPost("mcq_options");

        

    

       //throw new \CodeIgniter\Exceptions\PageNotFoundException($old_options);

        // ids of the question_ids of original questions (before editing)
        // this is only populated when editing and submitting an edited survey with some
        // pre-existing questions edited.
        $existing_question_ids = $this->request->getPost("question_ids"); 

        //throw new \CodeIgniter\Exceptions\PageNotFoundException($existing_question_ids[0]);

        // survey data to be inserted/updated
        $surveyData = [
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description
        ];

        // If no survey_id is provided, it's an add survey operation.
        if ($survey_id === null) {

            if ($surveyModel->insert($surveyData)) {
                // If the survey is successfully added, set a success message.
                $this->session->setFlashdata('success', 'Survey added successfully.');

                $survey_id = $surveyModel->insertID();
                

                foreach ($questions as $index => $question) {
                    // Add both question ID and corresponding text to the response data array
                    $questionData[] = [
                        'survey_id' => $survey_id,
                        'question_text' => $question,
                        'question_type' => $question_types[$index],
                        'order' => 1 //not currently using this so just set to 1.
                    ];
                }

                if ($questionModel->insertBatch($questionData)) {
                    // If the user is successfully added, set a success message.
                    $this->session->setFlashdata('success', 'Question added successfully.');
                } else {
                    // If the addition fails, set an error message.
                    $this->session->setFlashdata('error', 'Failed to add question. Please try again.');
                }

                // Get the IDs of the inserted MCQ questions
                $insertedIds = [];
                $MCQIndex = 0;
                foreach ($questionData as $index => $question) {
                    if ($question['question_type'] === 'MCQ') {
                        $insertedIds[] = $questionModel->insertID() + $MCQIndex;
                        $MCQIndex++;
                    }
                }

                // Get the option data for each option
                $optionsData = [];
                $question_num = -1;
                foreach ($options as $question_options) {
                    $question_num++;
                    // Iterate over the options for this question
                    foreach ($question_options as $option) {
                        // Add option data with the corresponding question ID
                        $optionsData[] = [
                            'question_id' => $insertedIds[$question_num],
                            'option_text' => $option,
                            'order' => 1, // not currently used, just set to 1
                            'is_correct' => 1 // not currently used, just set to 1
                            // You can add other attributes if needed
                        ];
                    }
                }

                // insert into option model
                $optionModel->insertBatch($optionsData);

            } else {
                // If the addition fails, set an error message.
                $this->session->setFlashdata('error', 'Failed to add survey. Please try again.');
            }
        } else {
            // If a survey_id is provided, it's an edit operation.
            if ($surveyModel->update($survey_id, $surveyData)) {
                // If the survey is successfully updated, set a success message.
                $this->session->setFlashdata('success', 'Survey updated successfully.');

                foreach ($existing_question_ids as $index => $existing_question_id) {
                    // populate array for updated question data
                    $existingQuestionData[] = [
                        'question_id' => $existing_question_id,
                        'survey_id' => $survey_id,
                        // this only works since pre-existing questions will always be at the top.
                        // If I add a way to rearrange questions THIS WILL BREAK.
                        'question_text' => $questions[$index], 
                        'question_type' => $question_types[$index],
                        'order' => 1 //not currently using this so just set to 1.
                    ];
                }

                $start_index = count($existing_question_ids);
                $questionCount = count($questions);
                $newQuestionData = [];
                for ($index = $start_index; $index < $questionCount; $index++) {
                    // Add both question ID and corresponding text to the response data array
                    $newQuestionData[] = [
                        'survey_id' => $survey_id,
                        'question_text' => $questions[$index],
                        'question_type' => $question_types[$index],
                        'order' => 1 //not currently using this so just set to 1.
                    ];
                }

                // update edited existing questions.
                if ($questionModel->updateBatch($existingQuestionData, 'question_id')) {
                    // If the user is successfully added, set a success message.
                    $this->session->setFlashdata('success', 'Question updated successfully.');
                } else {
                    // If the addition fails, set an error message.
                    $this->session->setFlashdata('error', 'Failed to update question. Please try again.');
                }

                // handle deleting removed questions
                $questions = $questionModel->where('survey_id', $survey_id)->findAll();
                $questionIds = array_map(function($question) {
                    return $question['question_id'];
                }, $questions);
                $deletedQuestions = array_diff($questionIds, $existing_question_ids);

                // if we have deleted questions while editing, delete them from db.
                if (!empty($deletedQuestions)) {
                    foreach ($deletedQuestions as $deletedQuestion) {
                        $questionModel->delete($deletedQuestion);
                    }
                }
                

                // if we have added new questions while editing, insert them.
                if (!empty($newQuestionData)) {
                    if ($questionModel->insertBatch($newQuestionData)) {
                        // If the user is successfully added, set a success message.
                        $this->session->setFlashdata('success', 'Question added successfully.');
                    } else {
                        // If the addition fails, set an error message.
                        $this->session->setFlashdata('error', 'Failed to add question. Please try again.');
                    }
                }
                
                // // handle adding new options to existing questions
                // $optionsData = [];
                // $question_num = -1;
                // if (!empty($old_options)) {
                //     foreach ($old_options as $question_options) {
                //         $option_num = 0;
                //         $question_num++;
                //         $options = $optionModel->where('question_id', $existing_question_ids[$question_num])->findAll();
                //         // Iterate over the options for this question
                //         foreach ($question_options as $option) {
                //             $option_num++;
                //             // Add option data with the corresponding question ID
                //             $optionsData[] = [
                //                 'option_id' => $options[$option_num-1]['option_id'],
                //                 'question_id' => $existing_question_ids[$question_num],
                //                 'option_text' => $option,
                //                 'order' => 1, // not currently used, just set to 1
                //                 'is_correct' => 1 // not currently used, just set to 1
                //                 // You can add other attributes if needed
                //             ];
                //         }
                //         if ($question_num == count($existing_question_ids)) {
                //             break;
                //         }
                //     }
                //     $optionModel->updateBatch($optionsData, 'option_id');
                // }
                

                // handle options of 


            } else {
                // If the update fails, set an error message.
                $this->session->setFlashdata('error', 'Failed to update survey. Please try again.');
            }
        }

        // Redirect back to the user's survey page
        return redirect()->to('surveys/'.$user_id);
    }

    // get user data of provided user
    $data['user'] = $userModel->find($user_id);

    // If the request is a GET request, load the edit form with existing survey data (for edit) or as blank (for add).
    $data['survey'] = ($survey_id === null) ? null : $surveyModel->find($survey_id);

    // Fetch current survey questions if edit
    if (!($survey_id === null)) {
        $data['questions'] = $questionModel->where('survey_id', $survey_id)->findAll();
    }

    // Initialize an array to store options
    $data['options'] = [];

    // get the options for each mcq question
    if (!empty($data['questions']))
    foreach ($data['questions'] as $question) {
        $options = $optionModel->where('question_id', $question['question_id'])->findAll();
        // Merge options into the options array
        $data['options'] = array_merge($data['options'], $options);
    }

   // $data['questions'] = $questionModel->where('survey_id', $survey_id)->findAll();

    // Display the add/edit form view, passing in the user data if available.
    return view('addeditSurvey', $data);
}

  /**
 * Controller method for deleting surveys. 
 * 
 * @param int $user_id The id of the user the survey belongs to.
 * @param int $survey_id The id survey to be deleted. 
 * 
 * @return Redirect Redirect to user's survey page
 */
public function deleteSurvey($user_id, $survey_id)
{
    // Instantiate the UserModel to interact with the database.
    $surveyModel = new \App\Models\SurveyModel();

    // Attempt to delete the user with the provided ID.
    if ($surveyModel->delete($survey_id)) {
        // If the deletion is successful, set a success message in the session flashdata.
        $this->session->setFlashdata('success', 'User deleted successfully.');
    } else {
        // If the deletion fails, set an error message in the session flashdata.
        $this->session->setFlashdata('error', 'Failed to delete user. Please try again.');
    }

    // Redirect to users survey page
    return redirect()->to('surveys/'.$user_id);
}


}