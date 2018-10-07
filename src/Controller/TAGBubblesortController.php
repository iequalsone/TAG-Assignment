<?php

/**
 * @file
 * Controller for generating JSON response.
 */

namespace Drupal\tag_bubblesort\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller for bubblesort routes.
 */
class TAGBubblesortController extends ControllerBase
{

    /**
     * Returns JSON data of form inputs.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *   A JSON response containing the sorted numbers.
     */
    public function bubblesortJson($data)
    {
        if (empty($data)) {
            $numbers = numbers_generate();
        } else {
            $data_parts = explode('&', $data);
            foreach ($data_parts as $part) {
                $fields[] = explode('=', $part);
            }
            // Loop through each field and grab values.
            foreach ($fields as $field) {
                if (!empty($field[1])) {
                    switch ($field[0]) {
                        case 'numbers_total':
                            $total = $field[1];
                            break;

                        case 'integer_min':
                            $range1 = $field[1];
                            break;

                        case 'integer_max':
                            $range2 = $field[1];
                            break;
                    }
                }
            }
            // Generate the random numbers within range.
            $numbers = $this->numbersGenerate($total, $range1, $range2, false);
        }
        // Return a response as JSON.
        return new JsonResponse($numbers);
    }

    /**
     * Generates random numbers between delimiters.
     *
     * @param int $total
     *   The total number of bars.
     * @param int $range1
     *   The starting number.
     * @param int $range2
     *   The ending number.
     *
     * @return array
     *   An array of randomly generated numbers.
     */
    private function numbersGenerate($total = 10, $range1 = 1, $range2 = 100, $sort = false)
    {
        $numbers = range($range1, $range2);
        shuffle($numbers);
        $numbers = array_slice($numbers, 0, $total);
        if ($sort) {
            rsort($numbers);
        }
        return $numbers;
    }
}
