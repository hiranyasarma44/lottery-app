<?= $this->extend('layouts/default') ?>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
</script>
<?= $this->endSection() ?>
<?= $this->section('script-body') ?>
<script>
  $(document).ready(function() {
    $('#lotteryListTable').DataTable();
  });
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h4 class="h4">Lottery List</h4>
  </div>

  <div class="table-responsive bg-primary p-2 rounded">
      <div class="clearfix mb-2">
        <div class="float-end" role="status">
          <button onclick="history.back()" class="btn btn-warning">Back</button>
        </div>
      </div>
    <table class="table table-sm table-hover" id="lotteryListTable">
      <thead>
        <tr class="align-top table-active">
          <th scope="col" width="5%">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col" width="10%">Price (in INR)</th>
          <th scope="col" width="12%">Held On</th>
          <th scope="col" width="15%">Result Date</th>
          <th scope="col" width="12%">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($gameList)) {
          foreach ($gameList as $sl => $game) {
            $title = strlen($game['title']) > 20 ? (str_split($game['title'], 20))[0] . '...' : $game['title'];
            $descriptions = strlen($game['descriptions']) > 50 ? (str_split($game['descriptions'], 50))[0] . '...' : $game['descriptions'];
        ?>
            <tr>
              <td><?= $sl + 1 ?></td>
              <td><?= $title ?></td>
              <td>
                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-title="<?= $game['title'] ?>" data-bs-content="<?= $game['descriptions'] ?>"><?= $descriptions ?></span>
              </td>
              <td><?= $game['price'] ?></td>
              <td><?= date('d-m-Y', strtotime($game['held_on'])) ?></td>
              <td><?= date('d-m-Y g:i a', strtotime($game['result_date'])) ?></td>
              <td>
                <a href="<?= base_url('details/'.$game['id']) ?>" class="btn btn-sm btn-outline-warning" title="View"><i class="bi bi-eye-fill"></i></a>
              </td>
            </tr>

        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>