<?php

add_shortcode('button_shortcode', 'elementor_button_shortcode');

function elementor_button_shortcode()
{
    return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Submit Design
</button>';
}


add_action('wp_footer', 'modal_form');
function modal_form()
{
    echo '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Details</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>

            <div class="modal-body">
                <form id="submitPopup" action="#" method="post" enctype="multipart/form-data">
                    <div class="row form-group">
                    <label for="inputName">Name</label>
                        <div class="col">
                            <input type="text" name="firstName" class="form-control" placeholder="First name" required>
                        </div>
                        <div class="col">
                            <input type="text" name="lastName" class="form-control" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" required>
                    </div> 
                    <div class="form-group">
                        <label for="inputPhone">Phone</label>
                        <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <select class="form-control" id="country" name="country">
                            <option value="">Choose Country</option>
                            ' . all_country_name() . '
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Participation Categories:</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="category" value="Statement Piece" required> Statement Piece
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="category" value="Convertible Jewelry" required> Convertible Jewelry
                        </label>                        
                        <label class="radio-inline">
                            <input type="radio" name="category" value="Perfume Bottle or Jewelry Box" required> Perfume Bottle or Jewelry Box
                        </label>
                    </div>                    
                    <div class="form-group">
                        <slabel>Participation Segments:</slabel><br>
                        <label class="radio-inline">
                            <input type="radio" name="segment" value="Sketch" required> Sketch
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="segment" value="CAD" required> CAD
                        </label>                        
                        <label class="radio-inline">
                            <input type="radio" name="segment" value="iPad" required> iPad
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="description">Text description:</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Up to 400 words! "></textarea>
                    </div>
                    <div class="form-group">
                        <label for="document">Upload:</label><br />
                        <input type="file" class="form-control-file" id="document" name="document" accept=".png,.svg,.jpeg,.jpg,.pdf,.docx" required>
                    </div></br>
                    <div class="text-center mx-auto">
                    <button class="btn btn-primary" type="submit">Submit Renewal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
}
