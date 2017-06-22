<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Permission_model extends MY_Model {

    public $belongs_to = array( 'module' );

    /*
     * Get a User access level for a module
     */
    public function module_access($user_id, $module_name)
    {
        $row = $this->db
            ->from('permissions')
            ->join('modules', 'modules.id = permissions.module_id')
            ->where(array(
                'user_id' => $user_id,
                'name' => strtolower($module_name),
                'access >=' => 1
            ))->get()->row_array();

            /*
            var_dump($this->db->last_query());
            exit();
            */
        return (empty($row)) ? FALSE : $row['access'];
    }

    /*
     * Get array of very module the user has
     * access to. Used for generating top menu.
     */
    public function get_modules($user_id)
    {
        $rows = $this->db
            ->from('permissions')
            ->join('modules', 'modules.id = permissions.module_id')
            ->where(array(
                'user_id' => $user_id,
                'access >=' => 1,
                'modules.id !=' => 1 // we dont want dashboard
            ))
            ->order_by('modules.order_by', 'desc')
            ->get()
            ->result_array();

        return $rows;
    }

    /*
     * Grants a User default permissions,
     * This function is called after a new User is created
     */
    public function setup_default($user_id)
    {
        $default_modules = array(1, 5);
        foreach($default_modules as $module_id)
        {
            $this->insert(array(
                'user_id' => $user_id,
                'module_id' => $module_id,
                'access' => 1
            ));
        }
    }

    /*
     * This function updates user permission from $this->input->post()
     */
    public function update_user($user_id)
    {
        $this->db
            ->where('user_id', $user_id)
            ->delete('permissions');

        foreach($this->input->post() as $name => $value)
        {
            if(substr($name, 0, 10) == 'permission' && $value > 0)
            {
                list( , $module_id) = explode('_', $name);
                $this->insert(array(
                    'user_id' => $user_id,
                    'module_id' => $module_id,
                    'access' => $value,
                ));
            }
        }
    }

}
//EOF
