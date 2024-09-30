let modalId;

function setModalParameters(modal, title, size, onEscape, backdrop, view, isDraggable = true) {
    modalId = `#${modal._element.id}`;
    const modalHeader = document.querySelector(`${modalId}-header`);
    const modalBody = document.querySelector(`${modalId}-body`);
    const modalTitle = document.querySelector(`${modalId}-title`);
    modalTitle.innerHTML = title;
    modal._dialog.classList.add(size);

    // if is empty typeof view or null or undefined or [] or {}
    if (typeof view === "string" && view.trim() !== "") {
        modalBody.innerHTML = view;
    }
    modal._config.backdrop = backdrop;
    modal._config.keyboard = onEscape;

    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener("click", () => modal.hide());
    });

    if (isDraggable) {
        makeDraggable();
    }

    modal.show();
    initializeAfterViewLoad();
}

function makeDraggable() {
    document.querySelectorAll(".modal-dialog").forEach(modalDialog => {
        modalDialog.style.cursor = "move";
        let isDragged = false;
        let currentX, currentY, initialX, initialY;
        let xOffset = 0, yOffset = 0;

        const dragStart = (e) => {
            if (["INPUT", "TEXTAREA", "SELECT", "SPAN"].includes(e.target.tagName) ||
                e.target.classList.contains("select2")) return;

            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            isDragged = true;
        };

        const dragEnd = () => isDragged = false;

        const drag = (e) => {
            if (!isDragged) return;
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            xOffset = currentX;
            yOffset = currentY;
            modalDialog.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
        };

        modalDialog.addEventListener("mousedown", dragStart);
        modalDialog.addEventListener("mouseup", dragEnd);
        modalDialog.addEventListener("mouseleave", dragEnd);
        modalDialog.addEventListener("mousemove", drag);
    });
}

function getDataTableLanguage() {
    return {
        lengthMenu: "Show _MENU_ entries per page",
        zeroRecords: "No matching records found",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "No records available",
        infoFiltered: "(filtered from _MAX_ total records)",
        search: "Search:",
        paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous",
        },
        processing: "Processing...",
        loadingRecords: "Loading...",
        emptyTable: "No data available in table",
        aria: {
            sortAscending: ": activate to sort column ascending",
            sortDescending: ": activate to sort column descending",
        },
        buttons: {
            copy: "Copy",
            colvis: "Column visibility",
        },
    };
}

function getDataTableLengthMenu() {
    return [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]];
}

function initializeAfterViewLoad() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('[data-control="select2"]').each(function () {
        const $select = $(this);
        const hideSearch = $select.data('hide-search');

        const select2Options = {
            language: {
                noResults: () => "No results found",
                inputTooShort: () => "Please enter more characters",
                searching: () => "Searching...",
                errorLoading: () => "Unable to load results"
            },
            dropdownParent: $(`${modalId}-body`),
            allowClear: true,
            width: "100%"
        };

        if (hideSearch === true || hideSearch === "true") {
            select2Options.minimumResultsForSearch = Infinity;
        }

        $select.select2(select2Options);
    });

    loadSpanishLocale();

}

function loadSpanishLocale() {
    (function (global, factory) {
        typeof exports === "object" && typeof module !== "undefined"
            ? factory(exports)
            : typeof define === "function" && define.amd
                ? define(["exports"], factory)
                : ((global =
                    typeof globalThis !== "undefined" ? globalThis : global || self),
                    factory((global.es = {})));
    })(this, function (exports) {
        "use strict";

        var fp =
            typeof window !== "undefined" && window.flatpickr !== undefined
                ? window.flatpickr
                : {
                    l10ns: {},
                };
        var Spanish = {
            weekdays: {
                shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                longhand: [
                    "Domingo",
                    "Lunes",
                    "Martes",
                    "Miércoles",
                    "Jueves",
                    "Viernes",
                    "Sábado",
                ],
            },
            months: {
                shorthand: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                ],
                longhand: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ],
            },
            ordinal: function () {
                return "º";
            },
            firstDayOfWeek: 1,
            rangeSeparator: " a ",
            time_24hr: true,
        };
        fp.l10ns.es = Spanish;
        var es = fp.l10ns;

        exports.Spanish = Spanish;
        exports.default = es;

        Object.defineProperty(exports, "__esModule", { value: true });
    });
}

function getSpanishDatePickerLocale() {
    return {
        format: "MM/DD/YYYY",
        applyLabel: "Apply",
        cancelLabel: "Cancel",
        fromLabel: "From",
        toLabel: "To",
        customRangeLabel: "Custom",
        daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        monthNames: [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ],
        firstDay: 0,
    };
}

function handleModalCancel(modal, cancelButton, form) {
    cancelButton.addEventListener("click", function (e) {
        e.preventDefault();
        Swal.fire({
            text: "Are you sure you want to cancel?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, cancel!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light",
            },
        }).then(function (result) {
            if (result.value) {
                form.reset();
                modal.hide();
            } else if (result.dismiss === "cancel") {
                Swal.fire({
                    text: "Your form has not been cancelled!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    });
}

function BASE_URL(url = '') {
    return window.BASE_URL + url;
}

class Toast {
    error = (message, title = 'Error') => {
        Swal.fire({
            icon: "error",
            title: title,
            html: message,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
        });
    }
    success = (message, title = 'Éxito') => {
        Swal.fire({
            icon: "success",
            title: this.title,
            html: message,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
        });
    }
    warning = (message, title = 'Advertencia') => {
        Swal.fire({
            icon: 'warning',
            title: title,
            html: message,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
        })
    }
    info = (message, title = 'Información') => {
        Swal.fire({
            icon: 'info',
            title: title,
            html: message,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-light",
            },
            buttonsStyling: false,
        })
    }
    mixin = () => {
        return Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });
    }
}

export {
    setModalParameters,
    getDataTableLanguage,
    getDataTableLengthMenu,
    handleModalCancel,
    BASE_URL,
    getSpanishDatePickerLocale,
    Toast,
};