<div class="row p-3">
    <div class="col-6">
        <div class="header-logo">
            <div class="col-md-2 col-sm-3 col-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="image pl-1">
                        <img src="{base_url}/assets/images/sheep.png" class="img-circle" style="width: 3rem;" alt="User Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="header-user">
            <div class="d-flex justify-content-end gap-3 align-items-center">
                <div class="info">
                    <span><?= $this->session->userdata('first_name').' '. $this->session->userdata('last_name')?></span>
                    <div></div>
                </div>
                <div class="image">
                    <img class="img-circle" src="<?= $this->session->userdata('picture') ? base_url($this->session->userdata('picture') ) : base_url('/assets/images/blank_person.jpg') ?>" style="width: 3rem;" alt="User Image">
                </div>
            </div>
        </div>
    </div>
</div>