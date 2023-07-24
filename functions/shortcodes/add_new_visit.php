<?php

// define new visit shortcode
function new_visit_form_shortcode()
{
    $form_header = '<div class="wrap">
        <form action="" method="post" id="" enctype="multipart/form-data"><table>';

    $date_of_visit = '<tr>
        <td><label for="">Date Of Visit</label></td>
         <td><input type="date" id="date_of_visit" name="date_of_visit" min="2023-06-23" max="2023-07-31" required/></td>
    </tr>';

    $number_of_children = '<tr>
         <td><label for="">Number of Children</label></td>
         <td><input type="number" name="number_of_children" id="number_of_children" min="0" required></td>
    </tr>';

    $number_of_adults = '<tr>
         <td><label for="">Number of Adults</label></td>
         <td><input type="number" name="number_of_adults" id="number_of_adults" min="0" required></td>
    </tr>';


    $city = '<tr>
         <td><label for="">City</label></td>
         <td>
            <select name="" id="city" required>
                <option value="beirut">Beirut</option>
                <option value="jounieh">Jounieh</option>
                <option value="tripoli">Tripoli</option>
                <option value="sidon">Sidon</option>
                <option value="baalbek">Baalbek</option>
                <option value="nabatieh">Nabatieh</option>
                <option value="tyre">Tyre</option>
                <option value="zahle">Zahle</option>
                <option value="zgharta_ehden">Zgharta-Ehden</option>
                <option value="byblos">Byblos</option>
                <option value="batroun">Batroun</option>
            </select>
         </td>
    </tr>';

    $ammount = '<tr>
         <td><label for="">Amount</label></td>
         <td><input type="text" id="amount" value="0" class="form-control" readonly></td>
         
    </tr>';

    $form_footer = '<tr class="buttons">
            <td><button id="new_visit" class="button back-btn">Reserve & Pay</button ></td>
        </tr>
    </table>
    </form>
    </div>';

    $form = $form_header . $date_of_visit . $number_of_children . $number_of_adults . $city . $ammount . $form_footer;
    return $form;

}
add_shortcode('new_vist', 'new_visit_form_shortcode');


