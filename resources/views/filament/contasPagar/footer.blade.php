
<div class="grid grid-cols-9 border-2 text-lg">
  <div class="col-start-1 col-span-5">TOTAL</div>
  <div class="col-start-6 col-end-7 border-0 text-center">R$ {{number_format(($this->getTableRecords()->sum('valor_parcela')),2, ",", ".") }}</div>
  <div class="col-start-7 col-end-9"></div>
  <div class="col-start-9 col-end-9 col-span-2 border-0 text-center border-0"> R$ {{number_format(($this->getTableRecords()->sum('valor_pago')),2, ",", ".") }}</div>

</div>

