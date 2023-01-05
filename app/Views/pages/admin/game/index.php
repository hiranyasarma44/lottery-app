<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3 class="h3">Game List</h3>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create
      </button>
      <!-- <button type="button" class="btn btn-sm btn-outline-success">Create</button> -->
    </div>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Price</th>
        <th scope="col">Held On</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>random</td>
        <td>data</td>
        <td>placeholder</td>
        <td>text</td>
        <td>
          <a href="" class="btn btn-sm btn-warning"><i class="bi bi-eye-fill"></i> View</a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<div class="modal modal-lg" tabindex="-1" id="exampleModal">
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
              <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
            </div>
            <div class="col-md-6">
              <label for="price" class="form-label">Price ( per ticket ) <span class="text-danger">*</span></label>
              <input type="text"  name="price" class="form-control" id="price" placeholder="100" required>
            </div>
            <div class="col-12">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" name="descriptions" id="description" placeholder="Place : ..., Address: ..." required></textarea>
            </div>
            <div class="col-6">
              <label for="banner_image" class="form-label">Banner Image <span class="text-danger">*</span></label>
              <input class="form-control" name="banner_image" type="file" id="banner_image" required>
            </div>
            <div class="col-6">
              <label for="ticket_image" class="form-label">Ticket Image <span class="text-danger">*</span></label>
              <input class="form-control" name="ticket_image" type="file" id="ticket_image" required>
            </div>
            <div class="col-6">
              <label for="ticket_image" class="form-label">Serial Number Range <span class="text-danger">*</span></label>
              <div class="input-group mb-3">
                <input type="number" class="form-control" name="start" placeholder="eg. 100" aria-label="Start" required>
                <input type="number" class="form-control" name="end" placeholder="eg. 999" aria-label="End" required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="opens_from" class="form-label">Opening Date <span class="text-danger">*</span></label>
              <input type="date" name="opens_from" class="form-control" id="opens_from" required>
            </div>
            <div class="col-md-6">
              <label for="heldOn" class="form-label">Held On <span class="text-danger">*</span></label>
              <input type="date" name="held_on" class="form-control" id="heldOn" required>
            </div>
            <div class="col-md-6">
              <label for="resultDate" class="form-label">Result Date <span class="text-danger">*</span></label>
              <input type="date" name="result_date" class="form-control" id="resultDate" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>