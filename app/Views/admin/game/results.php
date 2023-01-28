<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3 class="h3">Results</h3>
</div>

<div class="card text-start">
  <div class="card-body">
    <h4 class="card-title">Game Title</h4>
    <p class="card-text">Body</p>
    <hr>
    <form action="" method="POST">
      <div class="row">
        <div class="col">
          <label for="" class="form-label">Position</label>
          <input type="text" class="form-control" placeholder="Position" aria-label="First name">
        </div>
        <div class="col">
          <label for="" class="form-label">Number</label>
          <select class="form-control" placeholder="Number">
          </select>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <label for="" class="form-label">Winner</label>
          <select class="form-control" placeholder="Name">
          </select>
        </div>
        <div class="col">
          <label for="" class="form-label">Mobile Number</label>
          <select class="form-control" placeholder="Mobile Number">
          </select>
        </div>
      </div>
      <div class="d-grid gap-2 mt-4">
        <button class="btn btn-outline-primary" type="submit">Update</button>
      </div>
    </form>
  </div>
  <hr>

<div class="table-responsive">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th width="20%">Position</th>
        <th>Number</th>
        <th>Winner</th>
        <th width="30%">Winner Mobile Number</th>
      </tr>

    </thead>
    <tbody>
      <tr>
        <td></td>
        <td>
          <input type="text" class="form-control">
        </td>
        <td>
          <select name="" id="" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td>
          <select name="" id="" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
        <td>
          <select name="" id="" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<?= $this->endSection() ?>