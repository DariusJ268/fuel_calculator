<?php

namespace Drupal\fuel_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class fuel_calculatorForm extends FormBase {

    public function getFormId(){
        return 'fuel_calculator';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

        $distance_travelled = $form_state->getValue('distance_travelled') ?? 0;
        $fuel_consumption = $form_state->getValue('fuel_consumption') ?? 0;
        $price_per_liter = $form_state->getValue('price_per_liter') ?? 0;

        $form['distance_travelled'] = [
            '#type' => 'number',
            '#step' => '0.1',
            '#title' => 'Distance traveled, km',
            '#default_value' => $distance_travelled,
            '#required' => TRUE,
        ];
        
        $form['fuel_consumption'] = [
            '#type' => 'number',
            '#step' => '0.01',
            '#title' => 'Fuel consumption, l/100km',
            '#default_value' => $fuel_consumption,
            '#required' => TRUE,
        ];
        
        $form['price_per_liter'] = [
            '#type' => 'number',
            '#step' => '0.01',
            '#title' => 'Price per Liter, EUR',
            '#default_value' => $price_per_liter,
            '#required' => TRUE,
        ];

        $fuelSpent = round((($distance_travelled * $fuel_consumption)/100), 2);
    
        $form ['fuelSpent'] = [
            '#type' => 'markup',
            '#markup' => sprintf('Fuel spent %s liters.', $fuelSpent),
            '#suffix' => '<br>'
        ];
           
        $fuelCost =  round(($fuelSpent * $price_per_liter), 2);
       
        $form ['fuelCost'] = [
            '#type' => 'markup',
            '#markup' => sprintf('Fuel cost %s Euros.', $fuelCost),
            '#suffix' => '<br>'

        ];
        
        $form_state->setRedirect('fuel_calculator.submit', ['distance_travelled' => $distance_travelled, 'fuel_consumption' => $fuel_consumption, 'price_per_liter' => $price_per_liter]);

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Calculate',
            '#onclick' => 'updateUrl()'
        ];
        
        $form['actions']['reset'] = [
            '#type' => 'submit',
            '#value' => 'Reset',
            '#submit' => ['::resetForm']
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        if(!is_numeric($form_state->getValue('distance_travelled'))) {
            $form_state->setErrorByName('distance_travelled', 'The distance travelled must be a valid numeric value.');
          }
    
        if(!is_numeric($form_state->getValue('fuel_consumption'))) {
            $form_state->setErrorByName('fuel_consumption', 'The fuel consumption must be a valid numeric value.');
          }

        if(!is_numeric($form_state->getValue('price_per_liter'))) {
            $form_state->setErrorByName('price_per_liter', 'The price per liter must be a valid numeric value.');
          }

        if(($form_state->getValue('distance_travelled')) < 0) {
            $form_state->setErrorByName('distance_travelled', 'The distance travelled cannot be negative.');
          }
    
        if(($form_state->getValue('fuel_consumption')) < 0) {
            $form_state->setErrorByName('fuel_consumption', 'The fuel consumption cannot be negative.');
          }

        if(($form_state->getValue('price_per_liter')) < 0) {
            $form_state->setErrorByName('price_per_liter', 'The price per liter cannot be negative.');
          }
        
    }

    public function submitForm(array &$form, FormStateInterface $form_state){
        $distance_travelled = $form_state->getValue('distance_travelled');
        $fuel_consumption = $form_state->getValue('fuel_consumption');
        $price_per_liter = $form_state->getValue('price_per_liter');

        $url = \Drupal\Core\Url::fromRoute('fuel_calculator.submit', [
            'distance_travelled' => $distance_travelled,
            'fuel_consumption' => $fuel_consumption,
            'price_per_liter' => $price_per_liter,
        ]);

        $form_state->setRedirectUrl($url);
        $form_state->setRebuild();
    }

    public function resetForm(array &$form, FormStateInterface $form_state) {
        $form_state->setValue('distance_travelled', '0');
        $form_state->setValue('fuel_consumption', '0');
        $form_state->setValue('price_per_liter', '0');
        $form_state->setRebuild();
    }
    

}


?>