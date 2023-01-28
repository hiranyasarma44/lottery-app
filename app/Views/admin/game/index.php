<?php
$deleteFail = session()->getFlashdata('deleteFail');
$successMsg = session()->getFlashdata('successMsg');
$createErrors = session()->getFlashdata('createErrors');
$updateErrors = session()->getFlashdata('updateErrors');
?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
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


  async function viewGameInfo(gameKey) {
    let viewGameModal = new bootstrap.Modal(document.getElementById('viewGameInfo'))
    // make ajax call
    const res = await fetch('<?= base_url('/game/info') ?>/' + gameKey, {
      method: "get",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    })
    res.json().then(data => {
      if (data.status) {
        let gameInfo = data.gameInfo
        // fill info
        $('#viewTitle').text(gameInfo.title)
        $('#viewPrice').text(gameInfo.price)
        $('#viewDescription').text(gameInfo.descriptions)
        $('#viewBannerImage').attr('href', gameInfo.banner_image)
        $('#viewTicketImage').attr('href', gameInfo.ticket_image)
        $('#viewRangeStart').text(gameInfo.start)
        $('#viewRangeEnd').text(gameInfo.end)
        $('#viewOpensFrom').text(gameInfo.opens_from)
        $('#viewHeldOn').text(gameInfo.held_on)
        $('#viewResultDate').text(gameInfo.result_date)

        $('#gameResultLink').attr('href', '<?=base_url('game/results')?>/'+gameKey)
      } else {
        alert('Error:1')
      }
    })

    // show modal
    viewGameModal.show()
  }

  async function editGameInfo(gameKey) {

    let editGameModal = new bootstrap.Modal(document.getElementById('editGame'))
    // make ajax call
    const res = await fetch('<?= base_url('/game/info') ?>/' + gameKey, {
      method: "get",
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    })
    res.json().then(data => {
      if (data.status) {
        let gameInfo = data.gameInfo
        // fill info
        $('#gameKey').val(gameKey)
        $('#editTitle').val(gameInfo.title)
        $('#editPrice').val(gameInfo.price)
        $('#editDescription').val(gameInfo.descriptions)
        $('#editBannerImage').attr('href', '<?= base_url() ?>' + gameInfo.banner_image)
        $('#editTicketImage').attr('href', '<?= base_url() ?>' + gameInfo.ticket_image)
        $('#editRangeStart').val(gameInfo.start)
        $('#editRangeEnd').val(gameInfo.end)
        let openForm = gameInfo.opens_from.split('-')
        $('#editOpensFrom').val(openForm[2] + '-' + openForm[1] + '-' + openForm[0])
        let heldOn = gameInfo.held_on.split('-')
        $('#editHeldOn').val(heldOn[2] + '-' + heldOn[1] + '-' + heldOn[0])
        let resultDate = gameInfo.result_date.split('-')
        let meridiem = gameInfo.result_date.slice(-2)
        let resultYearNTime = resultDate[2].split(' ')
        let resultYear = resultYearNTime[0]
        let resultTimeArray = resultYearNTime[1].split(':')
        let hour = resultTimeArray[0].padStart(2, 0)
        let x = resultTimeArray[0] + ':' + resultTimeArray[1] + ' ' + meridiem
        let resultTimeString = moment(x, ["h:mm A"]).format("HH:mm")
        let resultDateTime = resultYear + '-' + resultDate[1] + '-' + resultDate[0] + 'T' + resultTimeString
        $('#editResultDate').val(resultDateTime)
      } else {
        alert('Error:1')
      }
    })

    // show modal
    editGameModal.show()
  }
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3 class="h3">Game List</h3>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addGame">
        Create
      </button>
    </div>
  </div>
</div>
<?php
  if($deleteFail){
?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error !!!</strong> <?=$deleteFail?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php
  }
?>

<?php
  if($successMsg){
?>

<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success : </strong> <?=$successMsg?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php
  }
?>

<div class="table-responsive">
  <table class="table table-sm" id="gameListTable">
    <thead>
      <tr>
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
              <button class="btn btn-sm btn-outline-warning" title="View" onclick="viewGameInfo(<?= $game['id'] ?>)"><i class="bi bi-eye-fill"></i></button>
              <button class="btn btn-sm btn-outline-primary" title="Edit" onclick="editGameInfo(<?= $game['id'] ?>)"><i class="bi bi-pencil-fill"></i></button>
              <a class="btn btn-sm btn-outline-danger" title="Delete"  href="<?=base_url('game/delete/'.$game['id'])?>" onclick='return confirm("Are you sure?")'><i class="bi bi-trash-fill"></i></a>
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
              if ($createErrors['title']) {
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
              if ($createErrors['price']) {
              ?>
                <p class="text-danger pt-1"><?= $createErrors['price'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-12">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" name="descriptions" id="description" placeholder="Place : ..., Address: ..." required><?= old('descriptions') ?></textarea>
              <?php
              if ($createErrors['descriptions']) {
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
              if ($createErrors['banner_image']) {
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
              if ($createErrors['ticket_image']) {
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
              if ($createErrors['start']) {
              ?>
                <p class="text-danger pt-1"><?= $createErrors['start'] ?></p>
              <?php
              }
              ?>
              <?php
              if ($createErrors['end']) {
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
              if ($createErrors['opens_from']) {
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
              if ($createErrors['held_on']) {
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
              if ($createErrors['result_date']) {
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

<!-- edit game modal  -->
<div class="modal modal-lg fade" tabindex="-1" id="editGame">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Game Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="<?= base_url('game/update') ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <?php
          if (!empty($createErrors)) {
          ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Errors!</strong> You should check in on some of those fields below.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php
          }
          ?>
          <input type="hidden" id='gameKey' name="id">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="editTitle" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" id="editTitle" placeholder="Title" required maxlength="250">
              <?php
              if ($updateErrors['title']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['title'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="editPrice" class="form-label">Price ( per ticket ) <span class="text-danger">*</span></label>
              <input type="text" name="price" class="form-control" id="editPrice" placeholder="100" required maxlength="10">
              <?php
              if ($updateErrors['price']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['price'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-12">
              <label for="editDescription" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" name="descriptions" id="editDescription" placeholder="Place : ..., Address: ..." required maxlength="1000"></textarea>
              <?php
              if ($updateErrors['descriptions']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['descriptions'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="banner_image" class="form-label">Banner Image</label>
              <div class="input-group mb-3">
                <input class="form-control" name="banner_image" type="file" id="banner_image">
                <a href="" id="editBannerImage" class="btn btn-warning" target="_blank">View</a>
              </div>
              <?php
              if ($updateErrors['banner_image']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['banner_image'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="ticket_image" class="form-label">Ticket Image</label>
              <div class="input-group mb-3">
                <input class="form-control" name="ticket_image" type="file" id="ticket_image">
                <a href="" id="editTicketImage" class="btn btn-warning" target="_blank">View</a>
              </div>
              <?php
              if ($updateErrors['ticket_image']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['ticket_image'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-6">
              <label for="sl_no" class="form-label">Serial Number Range <span class="text-danger">*</span></label>
              <div class="input-group mb-3">
                <input type="number" class="form-control" id="editRangeStart" name="start" placeholder="eg. 100" aria-label="Start" required>
                <input type="number" class="form-control" id="editRangeEnd" name="end" placeholder="eg. 999" aria-label="End" required>
              </div>
              <?php
              if ($updateErrors['start']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['start'] ?></p>
              <?php
              }
              ?>
              <?php
              if ($updateErrors['end']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['end'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="editOpensFrom" class="form-label">Opening Date <span class="text-danger">*</span></label>
              <input type="date" name="opens_from" class="form-control" id="editOpensFrom" required>
              <?php
              if ($updateErrors['opens_from']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['opens_from'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="editHeldOn" class="form-label">Held On <span class="text-danger">*</span></label>
              <input type="date" name="held_on" class="form-control" id="editHeldOn" required>
              <?php
              if ($updateErrors['held_on']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['held_on'] ?></p>
              <?php
              }
              ?>
            </div>
            <div class="col-md-6">
              <label for="editResultDate" class="form-label">Result Date <span class="text-danger">*</span></label>
              <input type="datetime-local" name="result_date" class="form-control" id="editResultDate" required>
              <?php
              if ($updateErrors['result_date']) {
              ?>
                <p class="text-danger pt-1"><?= $updateErrors['result_date'] ?></p>
              <?php
              }
              ?>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="updateGameInfo" value='updateGame' class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- view game info modal -->
<div class="modal modal-lg fade" tabindex="-1" id="viewGameInfo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Game Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-2">
                <label for="title" class="form-label">Title : </label>
              </div>
              <div class="col-md-10">
                <span id="viewTitle"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-5">

                <label for="title" class="form-label">Price (per ticket) : </label>
              </div>
              <div class="col-md-5">
                <span id="viewPrice"></span>
              </div>
            </div>
          </div>
          <div class="col-12">
            <label for="description" class="form-label">Description </label>

            <p id="viewDescription"></p>
          </div>
          <div class="col-6">
            <div class="row">
              <div class="col-md-5">
                <label for="banner_image" class="form-label">Banner Image </label>
              </div>
              <div class="col-md-5">
                <a href="" id="viewBannerImage" class="btn btn-sm btn-warning" target="_blank">View</a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="row">
              <div class="col-md-5">
                <label for="ticket_image" class="form-label">Ticket Image</label>
              </div>
              <div class="col-md-5">
                <a href="" id="viewTicketImage" class="btn btn-sm btn-warning" target="_blank">View</a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <label for="ticket_image" class="form-label">Serial Number Range</label>
            <div class="input-group mb-3 row">
              <div class="col-md-5">
                <label for="starts" class="form-label">Starts</label> :
                <span id="viewRangeStart"></span>
              </div>
              <div class="col-md-5">
                <label for="ends" class="form-label">Ends</label> :
                <span id="viewRangeEnd"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-5">
                <label for="opens_from" class="form-label">Opening Date : </label>
              </div>
              <div class="col-md-5">
                <span id="viewOpensFrom"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-5">
                <label for="heldOn" class="form-label">Held On : </label>
              </div>
              <div class="col-md-5">
                <span id="viewHeldOn"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-5">
                <label for="resultDate" class="form-label">Result Date : </label>
              </div>
              <div class="col-md-5">
                <span id="viewResultDate"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="d-grid gap-2">
          <a id="gameResultLink" href="#" class="btn btn-outline-info">Results</a>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>