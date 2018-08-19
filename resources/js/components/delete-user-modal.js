import $ from "jquery";

$("#deleteUserModal").on("show.bs.modal", function(e) {
  const userId = $(e.relatedTarget).data("userId");
  const deleteUserForm = $("#deleteUserForm");

  const action = deleteUserForm.attr("action");
  const actionArray = action.split("/");
  const currentUserId = actionArray[actionArray.length - 1];
  const newAction = action.replace(currentUserId, userId);

  deleteUserForm.attr("action", newAction);
});
