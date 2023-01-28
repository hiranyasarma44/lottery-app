<?= $this->extend('layouts/default') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>

<?= $this->section('script-head') ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2-multiple').select2({
      dropdownParent: $('#buyTicket'),
      placeholder: 'Select one or more ticket',
      theme: 'bootstrap-5'
    });
  });
</script>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container">
  <div class="card mt-4 border-light card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
    <div class="card-body">
      <div class="clearfix">
        <div class="float-end" role="status">
          <button onclick="history.back()" class="btn btn-warning">Back</button>
        </div>
      </div>
      <h5 class="card-title"><?= $gameInfo['title'] ?> <span class="text-right">x</span></h5>
      <p class="card-text"><?= $gameInfo['descriptions'] ?></p>
      <ul class="d-flex list-unstyled mt-auto">
        <li class="d-flex align-items-center me-3">
          <i class="bi bi-calendar-date"></i>&nbsp;
          <small title="Date"><?= date('d-m-Y', strtotime($gameInfo['result_date'])) ?></small>
        </li>
        <li class="d-flex align-items-center me-3">
          <i class="bi bi-alarm"></i>&nbsp;
          <small title="Time"><?= date('g:i a', strtotime($gameInfo['result_date'])) ?></small>
        </li>
        <li class="d-flex align-items-center me-3">
          <i class="bi bi-tags"></i>&nbsp;
          <small title="Price"><?= $gameInfo['price'] . ' INR' ?></small>
        </li>
        <li class="d-flex align-items-center">
          <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#buyTicket">
            <i class="bi bi-cart3 p-2"></i>
            Buy Tickets
          </a>
        </li>
      </ul>
    </div>
    <img src="<?= base_url('uploads/tickets' . $gameInfo['ticket_image']) ?>" class="card-img-bottom" alt="<?= $gameInfo['title'] ?>">
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>

<!-- add game modal -->
<div class="modal modal-lg fade" tabindex="-1" role="dialog" aria-hidden="true" id="buyTicket">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buy Ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="<?= base_url('game/create') ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="title" class="form-label">Tickets <span class="text-danger">*</span></label>
              <select name="tickets" id="tickets[]" class="form-select select2-multiple" style="width: 100%" multiple>
                <?php
                $serial_no_range = json_decode($gameInfo['serial_no_range']);
                foreach ($tickets as $ticket) {
                ?>
                  <option value="<?= $ticket['id'] ?>"><?= $ticket['sl_no'] ?></option>
                <?php
                }
                ?>
              </select>
              <?php
              if ($createErrors['tickets']) {
              ?>
                <p class="text-danger pt-1"><?= $createErrors['tickets'] ?></p>
              <?php
              }
              ?>
            </div>

            <div class="col-md-6">
              <label for="" class="form-label">Name</label>
              <input type="email" class="form-control" id="card-number" placeholder="Name">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="" class="form-label">Mobile Number</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="mobileNumber" placeholder="Mobile Number" aria-label="mobileNumber" value="" required="">
                <button class="btn btn-outline-success">Send OTP</button>
                <!-- <input type="text" class="form-control" name="otp" placeholder="OTP" aria-label="otp" value="" required="">
                <button class="btn btn-outline-warning" >Verify</button> -->
              </div>
            </div>
            <div class="col">
              <label for="card-number" class="form-label">Email ID</label>
              <input type="email" class="form-control" id="card-number" placeholder="Email ID">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-success" name="makePayment" value="makePayment" disabled>Make Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>