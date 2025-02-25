<?php namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ResultsController extends BaseController
{
    public function __construct()
 {
     
     helper('url'); 
     $this->session = session();
 }

public function results($user_id, $survey_id)
{
    $responseModel = new \App\Models\ResponseModel();
    $questionModel = new \App\Models\QuestionModel();
    $surveyModel = new \App\Models\SurveyModel();
    $optionModel = new \App\Models\OptionModel();

    $data['survey'] = $surveyModel->find($survey_id);

    // Check if the survey exists
    if (!$data['survey']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Survey Not Found');
    }

    // Fetch survey questions
    $data['questions'] = $questionModel->where('survey_id', $survey_id)->findAll();

    // Fetch responses for each question and calculate percentages for MCQ questions using options table
    $data['responses'] = [];
    $data['options'] = [];
    foreach ($data['questions'] as $question) {
        // Original method to fetch responses
        $responses = $responseModel->where('question_id', $question['question_id'])->findAll();
        $options = $optionModel->where('question_id', $question['question_id'])->findAll();

        // Calculate percentages for MCQ questions
        if ($question['question_type'] === 'MCQ') {
            $countResponses = $responseModel->select('text, COUNT(*) AS count')
                ->where('question_id', $question['question_id'])
                ->groupBy('text')
                ->findAll();

            $totalResponses = array_sum(array_column($countResponses, 'count'));
            
            foreach ($options as &$option) {
                // Initialize percentage to 0 for all options
                $option['percentage'] = 0; // Default is 0% if no one has answered that option.
                $option['count'] = 0;
            }

            // Loop through each option and add percentage attribute
            foreach ($options as &$option) {
                foreach ($countResponses as $countResponse) {
                    if ($option['option_text'] === $countResponse['text']) {
                        $percentage = ($totalResponses > 0) ? ($countResponse['count'] / $totalResponses) * 100 : 0;
                        $option['percentage'] = round($percentage, 1);
                        $option['count'] = $countResponse['count'];
                        break; // Break inner loop once percentage is calculated for this option
                    }
                }
            }
        }

        // Merge updated options array into the options stored in data
        $data['options'] = array_merge($data['options'], $options);
        $data['responses'] = array_merge($data['responses'], $responses);
        
}

    return view('results', $data);
}

/**
 * Controller method for handling listing responses to free text questions.
 * 
 * @param int $question_id The ID of the question being analysed.
 * @param int $survey_id The ID of the survey of which the question belongs to
 * 
 * @return View The view displaying the responses to the provided free text question.
 */
public function freeTextResult($user_id, $survey_id, $question_id)
{
    $responseModel = new \App\Models\ResponseModel();
    $questionModel = new \App\Models\QuestionModel();

    // extract question data from model, ensure question is free text.
    $data['question'] = $questionModel->where('question_type', 'Free Text')->find($question_id);

    if (!$data['question']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Free text question not found');
    }

    $data['responses'] = $responseModel->where('question_id', $question_id)->findAll();


    return view('freeTextResult', $data);
}

/**
 * Controller method for handling free text question AI responses summaries
 * 
 * @param int $question_id The ID of the question being analysed.
 * @param int $survey_id The ID of the survey of which the question belongs to
 * 
 * @return View The view displaying the AI summary of the provided free text question.
 */
public function AISummary($user_id, $survey_id, $question_id)
{
    $responseModel = new \App\Models\ResponseModel();
    $questionModel = new \App\Models\QuestionModel();

    // extract question data from model, ensure question is free text.
    $data['question'] = $questionModel->where('question_type', 'Free Text')->find($question_id);
    if (!$data['question']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Free text question not found');
    }

    $data['responses'] = $responseModel->where('question_id', $question_id)->findAll();
    $question_text = $data['question']['question_text'];

    $responseStrings = array_column($data['responses'], 'text');
    $allResponses = implode(', ', $responseStrings);

    // prompt used to generate survey analysis
    $prompt = "Please act as a survey analyser. The survey question asked was: ' . $question_text . ', and this is a list of the responses '[ . $allResponses . ]'. Give me a short summary of the trends and themes in the responses. Regardless of the quality of survey answers please attempt an answer. Say nothing before or after the analysis. If the list of provided responses is empty then explain that it is empty.";

        $client = new Client();
        $apiKey = getenv('CLAUDE_API_KEY');
        $anthropicVersion = '2023-06-01';
        $model = 'claude-3-haiku-20240307';
        $maxTokens = 1024;
        $messages = [
            ['role' => 'user', 'content' => $prompt]
        ];

        try {
            $response = $client->post('https://api.anthropic.com/v1/messages', [
                'headers' => [
                    'x-api-key' => $apiKey,
                    'anthropic-version' => $anthropicVersion,
                    'content-type' => 'application/json'
                ],
                'json' => [
                    'model' => $model,
                    'max_tokens' => $maxTokens,
                    'messages' => $messages
                ]
            ]);

            $responseBody = $response->getBody();
            $responseData = json_decode($responseBody, true);

            $returned_summary = $responseData["content"][0]["text"];

        } catch (RequestException $e) {
            // Handle request exceptions
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                $responseBody = $response->getBody()->getContents();
                // Handle the error response
                // ...
            } else {
                // Handle other request errors
                // ...
            }
        }

        $data['returned_summary'] = $returned_summary;
    return view('AISummary', $data);
}
}