
<div class="modal fade" id="feesBreakdownModal" tabindex="-1" role="dialog" aria-labelledby="feesBreakdownModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="feesBreakdownModalLabel">Fees Breakdown</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $arm->schoolclass->name.' '.$arm->name }} Fees & Other items</b><br />
                <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <?php $sn = 1; ?>
                    @foreach ($arm->items as $item)
                        <tr>
                            <td>{{ $sn.'.' }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ $item->currency_symbol.' '.$item->amount }}</td>
                        </tr>
                        <?php $sn++; ?>
                    @endforeach
                </table>
            </div>
        </div>
      </div>
    </div>
</div>