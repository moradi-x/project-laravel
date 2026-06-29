import './bootstrap';

import Swal from 'sweetalert2'
import { multipleSelect } from 'multiple-select-vanilla';
multipleSelect('.multiple-select');

import 'multiple-select-vanilla/dist/styles/css/multiple-select.css';

const message = document.querySelector('#message');

if (message) {
  Swal.fire({
    title: 'Success!',
    text: message.getAttribute('value'),
    icon: 'success',
    confirmButtonText: 'Ok'
  })
}


window.deleteitem = function (id, title) {
  Swal.fire({
    title: "Are you sure?",
    text: `You are deleteing \`${title}\` .`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      const item = document.querySelector('#delete-item-' + id);
      item.submit();
    }
  });
}

window.restoreItem = function (id, title) {
  Swal.fire({
    title: "Are you sure?",
    text: `You are restoring \`${title}\` .`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, restore it!"
  }).then((result) => {
    if (result.isConfirmed) {
      const item = document.querySelector('#restore-item-' + id);
      item.submit();
    }
  });
}
window.forceDeleteItem = function (id, title) {
  Swal.fire({
    title: "Are you sure?",
    text: `You are force deleteing \`${title}\` .`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, force delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      const item = document.querySelector('#force-Delete-item-' + id);
      item.submit();
    }
  });
}

window.changeitem = function (id, title) {
  Swal.fire({
    title: "Are you sure?",
    text: `You are changing \`${title}\` .`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, change it!"
  }).then((result) => {
    if (result.isConfirmed) {
      const item = document.querySelector('#change-item-' + id);
      item.submit();
    }
  });
}

// window.restoreitem = function (id, title) {
//   Swal.fire({
//     title: "Are you sure?",
//     text: `You are reseting Password for \`${title}\` .`,
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "Yes, resete it!"
//   }).then((result) => {
//     if (result.isConfirmed) {
//       const item = document.querySelector('#resetore-item-' + id);
//       item.submit();
//     }
//   });
// }
