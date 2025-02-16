<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              <div>
                <h3 class="fw-bold mb-3">Daftar Brand</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-info btn-sm"><span class="btn-label"><i class="fas fa-sync"></i></span> Reload</button>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="btn-label"><i class="fa fa-plus"></i></span> Tambah</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        ...
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
              id="basic-datatables"
              class="display table table-striped table-hover"
              >
              <thead>
                <tr>
                  <th>Name Brand</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Acero</td>
                  <td></td>
                  <td>
                    <button type="button" class="btn btn-icon btn-round btn-danger delete" ><i class="fas fa-trash-alt"></i></button>

                    <button type="button" class="btn btn-icon btn-round btn-info"><i class="far fa-edit"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>Acr</td>
                  <td></td>
                  <td>
                    <button type="button" class="btn btn-icon btn-round btn-danger delete"><i class="fas fa-trash-alt"></i></button>
                    <button type="button" class="btn btn-icon btn-round btn-info"><i class="far fa-edit"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>
 $(".delete").click(function (e) {
  swal({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    type: "warning",
    buttons: {
      cancel: {
        visible: true,
        text: "No, cancel!",
        className: "btn btn-danger",
      },
      confirm: {
        text: "Yes, delete it!",
        className: "btn btn-success",
      },
    },
  }).then((willDelete) => {
    if (willDelete) {
      swal("Poof! Your imaginary file has been deleted!", {
        icon: "success",
        buttons: {
          confirm: {
            className: "btn btn-success",
          },
        },
      });
    } else {
      swal("Your imaginary file is safe!", {
        buttons: {
          confirm: {
            className: "btn btn-success",
          },
        },
      });
    }
  });
});
</script>