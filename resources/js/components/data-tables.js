import $ from "jquery";
import "datatables.net";
import "datatables.net-bs4";

$("#user-table-js").DataTable({
  "order": [[ 0, "desc" ]],
  "pageLength": 100
});

$("#order-table-js").DataTable({
  "order": [[ 0, "desc" ]],
  "pageLength": 100
});
