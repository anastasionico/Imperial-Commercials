<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * http://www.capnetwork.co.uk/
 */
class Cap_model extends CI_Model {

    protected $subscriber_id = 156343;
    protected $password = '343Imp';

    public function get_manufacturers() {

        $vehicles = $this->db->get('cap_manufacturers')->result_array();
        foreach($vehicles as &$vehicle) {
            $vehicle['code'] = $vehicle['id'];
        }
        /*
        $client = new SoapClient('http://webservices.capnetwork.co.uk/CAPVehicles_Webservice/capvehicles.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'JustCurrentManufacturers' => 'false',
            'BodyStyleFilter' => '',
        );
        $response = $client->__soapCall('GetCAPMan', array($params));
        $xml = new SimpleXMLElement($response->GetCAPManResult->Returned_DataSet->any);
        $vehicles = array();

        foreach ($xml->NewDataSet->Table as $table) {
            $vehicles[] = array(
                'code' => (string) $table->CMan_Code,
                'name' => (string) $table->CMan_Name,
            );
            $this->db->query('INSERT IGNORE INTO `cap_manufacturers`
                SET `id` = \'' . $table->CMan_Code . '\',
                `name` = \'' . $table->CMan_Name . '\'');
        }

         */
        return $vehicles;
    }

    public function get_manufacturer($id) {
        return $this->db->query('SELECT * FROM `cap_manufacturers`
            WHERE `id` = ' . $id)->row_array();
    }

    public function get_models($manufacturer_code) {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/CAPVehicles_Webservice/capvehicles.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'ManRanCode' => $manufacturer_code,
            'ManRanCode_IsMan' => 'true',
            'JustCurrentModels' => 'false',
            'BodyStyleFilter' => '',
        );
        $response = $client->__soapCall('GetCAPMod', array($params));
        $xml = new SimpleXMLElement($response->GetCAPModResult->Returned_DataSet->any);
        $models = array();

        if(! empty($xml->NewDataSet->Table) ) {
            foreach ($xml->NewDataSet->Table as $table) {
                $models[] = array(
                    'code' => (string) $table->CMod_Code,
                    'name' => (string) $table->CMod_Name,
                    'introduced' => (string) $table->CMod_Introduced,
                    'discontinued' => (string) $table->CMod_Discontinued,
                );
                $this->db->query('INSERT IGNORE INTO `cap_models`
                    SET `id` = \'' . $table->CMod_Code . '\',
                    `name` = \'' . $table->CMod_Name . '\',
                    `introduced` = \'' . $table->CMod_Introduced . '\',
                    `discontinued` = \'' . $table->CMod_Discontinued . '\'');
            }
        }

        if(empty($models)) {
            $models = $this->db->get('cap_models')->result_array();
            foreach($models as &$model) {
                $model['code'] = $model['id'];
            }
        }

        return $models;
    }

    public function get_derivatives($model_code) {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/CAPVehicles_Webservice/capvehicles.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'ModCode' => $model_code,
            'JustCurrentDerivatives' => 'false',
        );
        $response = $client->__soapCall('GetCAPDer', array($params));
        $xml = new SimpleXMLElement($response->GetCAPDerResult->Returned_DataSet->any);
        $derivatives = array();

        foreach ($xml->NewDataSet->Table as $table) {
            $derivatives[] = array(
                'id' => (string) $table->CDer_ID,
                'name' => (string) $table->CDer_Name,
                'introduced' => (string) $table->CDer_Introduced,
                'last_spec_date' => (string) $table->CDer_LastSpecDate,
                'model_year_ref' => (string) $table->CDer_ModelYearRef,
            );
            $this->db->query('INSERT IGNORE INTO `cap_derivatives`
                SET `id` = \'' . $table->CDer_ID . '\',
                `name` = \'' . $table->CDer_Name . '\',
                `introduced` = \'' . $table->CDer_Introduced . '\',
                `last_spec_date` = \'' . $table->CDer_LastSpecDate . '\',
                `model_year_ref` = \'' . $table->CDer_ModelYearRef . '\'');
        }

        return $derivatives;
    }

    public function get_technical_data($cap_id, $tech_date = '2015-10-13T00:00:00+01:00') {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/capnvd_webservice/capnvd.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'CAPID' => $cap_id,
            'TechDate' => $tech_date, // can be anything when JustCurrent is set to true
            'JustCurrent' => 'false',
        );
        $response = $client->__soapCall('GetTechnicalData', array($params));
        $xml = new SimpleXMLElement($response->GetTechnicalDataResult->Returned_DataSet->any);

        $data = array();

        foreach ($xml->TechnicalData->Tech as $table) {
            $data[] = array(
                'code' => (string) $table->Tech_TechCode,
                'description' => (string) $table->Dc_Description,
                'long_description' => (string) $table->DT_LongDescription,
                'value' => (string) $table->tech_value_string,
            );
        }

        return $data;
    }

    public function get_options_bundle($cap_id, $option_date = '2015-10-13T00:00:00+01:00') {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/capnvd_webservice/capnvd.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'CAPID' => $cap_id,
            'OptionDate' => $option_date,
            'JustCurrent' => 'true',
            'DescriptionRS' => 'true',
            'OptionsRS' => 'true',
            'RelationshipsRS' => 'true',
            'PackRS' => 'true',
            'TechnicalRS' => 'true',
        );
        $response = $client->__soapCall('GetCAPOptionsBundle', array($params));
        $xml = new SimpleXMLElement($response->GetCAPOptionsBundleResult->Returned_DataSet->any);

        $data = array();

        foreach ($xml->NVDBundle->Options as $table) {
            $data[] = array(
                'opt_option_code' => (string) $table->Opt_OptionCode,
                'do_description' => (string) $table->Do_Description,
                'dc_description' => (string) $table->Dc_Description,
                'opt_basic' => (string) $table->Opt_Basic,
                'opt_VAT' => (string) $table->Opt_VAT,
                'opt_Default' => (string) $table->Opt_Default,
                'opt_POA' => (string) $table->Opt_POA,
                'table_order' => (string) $table->TableOrder,
            );
        }

        return $data;
    }

    public function get_equipment($cap_id, $SEDate = '2015-10-13T00:00:00+01:00') {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/capnvd_webservice/capnvd.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'CAPID' => $cap_id,
            'SEDate' => $SEDate,
            'JustCurrent' => 'true',
        );
        $response = $client->__soapCall('GetStandardEquipment', array($params));
        $xml = new SimpleXMLElement($response->GetStandardEquipmentResult->Returned_DataSet->any);

        $data = array();

        foreach ($xml->StandardEquipement->SE as $table) {
            $data[] = array(
                'se_option_code' => (string) $table->Se_OptionCode,
                'do_description' => (string) $table->Do_Description,
                'dc_description' => (string) $table->Dc_Description,
            );
        }

        return $data;
    }
    public function get_cap_id($cap_code) {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/CAPVehicles_Webservice/capvehicles.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'CAPcode' => $cap_code,
        );
        $response = $client->__soapCall('GetCAPIDFromCAPcode', array($params));

        $xml = new SimpleXMLElement($response->GetCAPIDFromCAPcodeResult->Returned_DataSet->any);

        $test = $xml->NewDataSet->Table->CDer_ID;
        $answer = '';
        foreach($test as $value) {
            $answer = $value;
        }
        return (! empty($answer)) ? $answer : NULL;
    }

    public function get_description_from_id($cap_id) {
        $client = new SoapClient('http://webservices.capnetwork.co.uk/CAPVehicles_Webservice/capvehicles.asmx?WSDL');
        $params = array(
            'Subscriber_ID' => $this->subscriber_id,
            'Password' => $this->password,
            'Database' => 'LCV',
            'CAPID' => $cap_id,
        );
        $response = $client->__soapCall('GetCAPDescriptionFromID', array($params));
        $xml = new SimpleXMLElement($response->GetCAPDescriptionFromIDResult->Returned_DataSet->any);
        $description = array();

        foreach ($xml->NewDataSet->Table as $table) {
            $description[] = array(
                'manufacturer_text' => (string) $table->CVehicle_ManText, // => VOLKSWAGEN
                'model_text_short' => (string) $table->CVehicle_ShortModText, // => TRANSPORTER
                'model_text' => (string) $table->CVehicle_ModText, // => TRANSPORTER T26 SWB DIESEL
                'derivative_text' => (string) $table->CVehicle_DerText, // => 2.0 TDI BMT 84 Startline Van
                'manufacturer_code' => (string) $table->CVehicle_ManTextCode, // => 1567
                'model_code_short' => (string) $table->CVehicle_ShortModID, // => 158
                'model_code' => (string) $table->CVehicle_ModTextCode, // => 35445
            );
            /*
            $this->db->query('INSERT IGNORE INTO `cap_derivatives`
                SET `id` = \'' . $table->CDer_ID . '\',
                `name` = \'' . $table->CDer_Name . '\',
                `introduced` = \'' . $table->CDer_Introduced . '\',
                `last_spec_date` = \'' . $table->CDer_LastSpecDate . '\',
                `model_year_ref` = \'' . $table->CDer_ModelYearRef . '\'');
             */
        }

        return (count($description) == 1) ? $description[0] : NULL;
    }

    // dont think will be used now, will just do a join on vehicle model
    public function get_db_cache($table, $param1 = NULL) {
        switch($table) {
        case 'manufacturers':
            $data = array();
            foreach($this->db->get('cap_manufacturers')->result_array() as $manufacturer) {
                $data[$manufacturer['id']] = $manufacturer['name'];
            }
            break;
        }

        return $data;
    }

}
//EOF
