<?php if(empty($histories)): ?>

    <div class="alert alert-secondary mb-0">
        No history records found.
    </div>

<?php else: ?>

    <table class="table table-bordered align-middle fs-7 table-sm">

        <tr class="text-center">

            <th>Action</th>
            <th>Previous Due Date</th>
            <th>New Due Date</th>
            <th>Performed At</th>
            <th>Performed By</th>
            <th>Remarks</th>

        </tr>

        <?php foreach($histories as $history): ?>

            <tr>

                <td>
                    <?= ucfirst($history['action']) ?>
                </td>

                <td>
                    <?= $history['previous_due_date'] ?>
                </td>

                <td>
                    <?= $history['new_due_date'] ?>
                </td>

                <td>
                    <?= $history['performed_at'] ?>
                </td>

                <td>
                    <?= $history['performer_library_id'] ?> <br>
                    <?= $history['performer_full_name'] ?>
                </td>

                <td>
                    <?= $history['remarks'] ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </table>

<?php endif; ?>