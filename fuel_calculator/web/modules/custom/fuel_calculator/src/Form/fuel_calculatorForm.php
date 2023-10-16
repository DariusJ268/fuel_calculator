<?php

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;

class fuel_calculatorForm extends FormBase {

    public function getFormId(){
        return 'fuel_calculator';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

        $distance_travelled = is_float($form_state -> hasValue('distance_travelled')) ? floatval($form_state -> getValue('distance_travelled')) : '';
        $fuel_consumption = is_float($form_state -> hasValue('fuel_consumption')) ? floatval ($form_state -> getValue('fuel_consumption')) : '';
        $price_per_liter = is_float($form_state -> hasValue('price_per_liter')) ? floatval($form_state -> getValue('price_per_liter')) : '';
        
        $form ['distance_travelled'] = array(
            '#type' => 'textfield',
            '#title' => 'Distance traveled, km',
            '#default_value' => $distance_travelled,
            '#required' => TRUE
        );

        $form ['fuel_consumption'] = array(
            '#type' => 'textfield',
            '#title' => 'Fuel consumption, l/100km',
            '#default_value' => $fuel_consumption,
            '#required' => TRUE
        );

        $form ['price_per_liter'] = array(
            '#type' => 'textfield',
            '#title' => 'Price per Liter, EUR',
            '#default_value' => $price_per_liter,
            '#required' => TRUE
        );

        $fuelSpent = ($distance_travelled * $fuel_consumption)/100;
    
        $form ['fuelSpent'] = [
            '#type' => 'markup',
            '#markup' => sprintf('Fuel spent %s liters.', $fuelSpent),
            '#suffix' => '<br>'
        ];
           
        $fuelCost =  $fuelSpent * $price_per_liter;
       
        $form ['fuelCost'] = [
            '#type' => 'markup',
            '#markup' => sprintf('Fuel cost %s Euros.', $fuelCost),
            '#suffix' => '<br>'
        ];
        
           $form_state->setRedirect('fuel_calculator.submit', ['distance_travelled' => $distance_travelled, 'fuel_consumption' => $fuel_consumption, 'price_per_liter' => $price_per_liter]);

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Calculate',
            '#onclick' => 'updateUrl()'
        );

        $form['actions']['reset'] = array(
            '#type' => 'submit',
            '#value' => 'Reset'
        );

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        $distance_travelled = $form_state->getValue('distance_travelled');
        $fuel_consumption = $form_state->getValue('fuel_consumption');
        $price_per_liter = $form_state->getValue('price_per_liter');

        $url = \Drupal\Core\Url::fromRoute('fuel_calculator.calculator',[
            'distance_travelled' =>  $distance_travelled,
            'fuel_consumption' => $fuel_consumption,
            'price_per_liter' => $price_per_liter,
        ]);
        $response = new TrustedRedirectResponse($url->toString());
        $response->send();
    }
    

}

?>