<div class="mt-4 card border-light card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-image: url('<?= base_url('uploads/tickets' . $gameInfo['ticket_image']) ?>')">
    <div class="d-flex flex-column h-100 p-5 pb-3 text-dark text-shadow-1">
      <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold"><?= $gameInfo['title'] ?></h3>
      <p class="lead"><?= $gameInfo['descriptions'] ?></p>
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
          <a href="#" title="Buy Ticket" class="btn btn-sm btn-outline-danger stretched-link" data-bs-toggle="modal" data-bs-target="#buyTicket">
            <i class="bi bi-cart3"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>