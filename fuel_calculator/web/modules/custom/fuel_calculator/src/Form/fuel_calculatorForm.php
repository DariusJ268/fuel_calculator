<?php

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class fuel_calculatorForm extends FormBase {

    public function getFormId(){
        return 'fuel_calculator';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        
        $form ['distance_travelled'] = array(
            '#type' => 'textfield',
            '#title' => 'Distance traveled, km',
            '#value' => '0',
            '#required' => TRUE
        );

        $form ['fuel_consumption'] = array(
            '#type' => 'textfield',
            '#title' => 'Fuel consumption, l/100km',
            '#value' => '0',
            '#required' => TRUE
        );

        $form ['price_per_liter'] = array(
            '#type' => 'textfield',
            '#title' => 'Price per Liter, EUR',
            '#value' => '0',
            '#required' => TRUE
        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Calculate'
        );

        $form['actions']['reset'] = array(
            '#type' => 'submit',
            '#value' => 'Reset'
        );

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        if(){

        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
       public function fuelSpent(array ){
        
       }
    }

}

?>