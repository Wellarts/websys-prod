
<div class="grid grid-cols-8 border-2 text-lg">
  <div class="col-start-1 col-span-5">TOTAL</div>
  <div class="col-start-2 col-end-3 border-0 text-left"> R$ {{number_format(($this->getTableRecords()->sum('total_compra')),2) }}</div>
  <div class="col-start-3 col-end-4  border-0 text-left"> R$ {{ number_format(($this->getTableRecords()->sum('total_venda')),2) }}</div>
  <div class="col-start-4 col-end-5 border-0 text-center">R$ {{number_format(($this->getTableRecords()->sum('total_lucratividade')),2) }}</div>
</div>
