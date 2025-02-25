<?php namespace App\Controllers;

use CodeIgniter\Controller;


class AdminController extends BaseController
{
    public function __construct()
 {
     
     helper('url'); 
     $this->session = session();
 }

 /**
 * Controller method for displaying the admin panel, including search functionality.
 * 
 * @return View The view displaying the admin panel
 */
public function admin()
{
    $model = new \App\Models\UserModel();

    $search = $this->request->getGet('search');
    
    // Check if we submitted an empty search term.
    if (!empty($search)) {

        $conditions = [];
        
        // Create array of strings of sql "LIKE" operations between our search condition and all our 
        // user attributes
        foreach ($model->allowedFields as $field) {
            $conditions[] = "$field LIKE '%$search%'";
        }

        // turn our array of strings into a single string separated by OR
        $whereClause = implode(' OR ', $conditions);
        
        // We pass our where clause into an sql query to check if any of the user attributes
        // have the same pattern as our search term.
        $users = $model->where($whereClause)->orderBy('user_id', 'ASC')->findAll();
    } else {
        $users = $model->orderBy('user_id', 'ASC')->findAll(); //default to returning all users if there is no search term
    }
    
    $data['users'] = $users;
    
    return view('admin', $data);
}

/**
 * Controller method for adding/editing user details using the admin panel.
 * 
 * @param int $id If not null, the id of the user being edited. If null, we are adding a new user.
 * 
 * @return RedirectResponse The redirect URL back to the admin panel if adding or editing
 * a user. If we aren't submitting an add or edit we return a View to display the addeditUser view.
 * 
 */
public function addeditUser($id = null)
{
    $model = new \App\Models\UserModel();

    // Check if the request is a POST request (form submission).
    if ($this->request->getMethod() === 'POST') {
        // Retrieve the submitted form data.
        $data = $this->request->getPost();

        // If no ID is provided, it's an add operation.
        if ($id === null) {
            if ($model->insert($data)) {
                // If the user is successfully added, set a success message.
                $this->session->setFlashdata('success', 'User added successfully.');
            } else {
                // If the addition fails, set an error message.
                $this->session->setFlashdata('error', 'Failed to add user. Please try again.');
            }
        } else {
            // If an ID is provided, it's an edit operation.
            if ($model->update($id, $data)) {
                // If the user is successfully updated, set a success message.
                $this->session->setFlashdata('success', 'User updated successfully.');
            } else {
                // If the update fails, set an error message.
                $this->session->setFlashdata('error', 'Failed to update user. Please try again.');
            }
        }

        // Redirect back to the admin page after the operation.
        return redirect()->to('/admin');
    }

    // If the request is a GET request, load the form with existing user data (for edit) or as blank (for add).
    $data['user'] = ($id === null) ? null : $model->find($id);

    // Display the add/edit form view, passing in the user data if available.
    return view('addeditUser', $data);
}

/**
 * Controller method for deleting users using the admin panel.
 * 
 * @param int $id The id of the user being deleted.
 * 
 * @return RedirectResponse The redirect URL back to the admin panel after deletion
 */
public function deleteUser($id)
{
    // Instantiate the UserModel to interact with the database.
    $model = new \App\Models\UserModel();

    // Attempt to delete the user with the provided ID.
    if ($model->delete($id)) {
        // If the deletion is successful, set a success message in the session flashdata.
        $this->session->setFlashdata('success', 'User deleted successfully.');
    } else {
        // If the deletion fails, set an error message in the session flashdata.
        $this->session->setFlashdata('error', 'Failed to delete user. Please try again.');
    }

    // Redirect the administrator back to the admin page.
    return redirect()->to('/admin');
}

}