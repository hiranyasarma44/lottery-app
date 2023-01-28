<?= $this->extend('layouts/admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<style>
  .table,
  thead,
  th,
  tbody,
  td {
    text-align: center !important;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('script-head') ?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

<script>
</script>
<?= $this->endSection() ?>
<?= $this->section('script-body') ?>
<script>
  $(document).ready(function() {
    $('#gameListTable').DataTable();
  });
  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
  const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3 class="h3">Member List</h3>
</div>
<div class="table-responsive">
  <table class="table table-sm" id="gameListTable">
    <thead>
      <tr>
        <th scope="col" width="5%">#</th>
        <th scope="col">Name</th>
        <th scope="col">Mobile Number</th>
        <th scope="col" width="10%">Email ID</th>
        <th scope="col" width="12%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($memberList)) {
        foreach ($memberList as $sl => $member) {
      ?>
          <tr>
            <td><?= $sl + 1 ?></td>
            <td><?= $member['name'] ?></td>
            <td><?= $member['mobile_number'] ?></td>
            <td><?= $member['email_id'] ?></td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="viewMemberInfo(<?= $member['id'] ?>)"><i class="bi bi-eye-fill"></i> View</button>
            </td>
          </tr>

      <?php }
      } ?>
    </tbody>
  </table>
</div>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- add game modal -->
<div class="modal modal-lg fade" tabindex="-1" id="addGame">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Game</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="<?= base_url('game/create') ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" id="title" placeholder="Title" value='<?= old('title') ?>' required>
              <?php
              if ($createErrors['title']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['title'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="price" class="form-label">Price ( per ticket ) <span class="text-danger">*</span></label>
              <input type="text" name="price" class="form-control" id="price" placeholder="100" value='<?= old('price') ?>' required>
              <?php
              if ($createErrors['price']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['price'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-12">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" name="descriptions" id="description" placeholder="Place : ..., Address: ..." required><?=old('descriptions')?></textarea>
              <?php
              if ($createErrors['descriptions']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['descriptions'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="banner_image" class="form-label">Banner Image <span class="text-danger">*</span></label>
              <input class="form-control" name="banner_image" type="file" id="banner_image" required>
              <?php
              if ($createErrors['banner_image']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['banner_image'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="ticket_image" class="form-label">Ticket Image <span class="text-danger">*</span></label>
              <input class="form-control" name="ticket_image" type="file" id="ticket_image" required>
              <?php
              if ($createErrors['ticket_image']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['ticket_image'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="ticket_image" class="form-label">Serial Number Range <span class="text-danger">*</span></label>
              <div class="input-group mb-3">
                <input type="number" class="form-control" name="start" placeholder="eg. 100" aria-label="Start" value='<?= old('start') ?>' required>
                <input type="number" class="form-control" name="end" placeholder="eg. 999" aria-label="End" value='<?= old('end') ?>' required>
              </div>
              <?php
              if ($createErrors['start']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['start'] ?></p>
              <?php
              }
              ?>
              <?php
              if ($createErrors['end']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['end'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="opens_from" class="form-label">Opening Date <span class="text-danger">*</span></label>
              <input type="date" name="opens_from" class="form-control" id="opens_from" value='<?= old('opens_from') ?>' required>
              <?php
              if ($createErrors['opens_from']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['opens_from'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="heldOn" class="form-label">Held On <span class="text-danger">*</span></label>
              <input type="date" name="held_on" class="form-control" id="heldOn" value='<?= old('held_on') ?>' required>
              <?php
              if ($createErrors['held_on']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['held_on'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="resultDate" class="form-label">Result Date <span class="text-danger">*</span></label>
              <input type="datetime-local" name="result_date" class="form-control" id="resultDate" value='<?= old('result_date') ?>' required>
              <?php
              if ($createErrors['result_date']){
              ?>
                <p class="text-danger pt-1"><?= $createErrors['result_date'] ?></p>
              <?php
              }
              ?>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="createGameInfo" value='createGame'>Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>