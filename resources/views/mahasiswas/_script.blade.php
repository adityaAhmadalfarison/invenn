<script>
    $(document).ready(function () {
        // Check if DataTable is already initialized and destroy it
        if ($.fn.DataTable.isDataTable('#datatable')) {
            $('#datatable').DataTable().destroy();
        }
    
        // Initialize DataTable
        $('#datatable').DataTable({
            // Your DataTable options here
        });
    
        // Handle modal show event
        $(".show-modal").click(function () {
            const id = $(this).data("id");
            let url = "{{ route('mahasiswas.show', ':paramID') }}".replace(":paramID", id);
    
            $.ajax({
                url: url,
                header: {
                    "Content-Type": "application/json",
                },
                success: (res) => {
                    $("#show_mahasiswa #name").val(res.data.name);
                    $("#show_mahasiswa #email").val(res.data.email);
                    $("#show_mahasiswa #role_id").val(res.data.role.name);
                },
                error: (err) => {
                    alert("error occurred, check console");
                    console.log(err);
                },
            });
        });
    
        // Handle modal edit event
        $(".edit-modal").on("click", function () {
            const id = $(this).data("id");
            let url = "{{ route('mahasiswas.show', ':paramID') }}".replace(":paramID", id);
    
            let updateURL = "{{ route('mahasiswas.update', ':paramID') }}".replace(":paramID", id);
    
            $.ajax({
                url: url,
                method: "GET",
                header: {
                    "Content-Type": "application/json",
                },
                success: (res) => {
                    $("#mahasiswa_edit_modal form #name").val(res.data.name);
                    $("#mahasiswa_edit_modal form #email").val(res.data.email);
                    if(res.data.role !== null) {
                        userRoleInput.setValue(res.data.role.id);
                    }
                    $("#mahasiswa_edit_modal form").attr("action", updateURL);
                },
                error: (err) => {
                    alert("error occurred, check console");
                    console.log(err);
                },
            });
        });
    });
    </script>