

<div class="grid grid-cols-9 border-2 text-lg">
  <div class="col-start-1 col-span-5">TOTAL</div>
  <div class="col-start-7 col-end-8 border-0 text-center border-0"> R$ {{number_format(($this->getTableRecords()->sum('valor_parcela')),2, ",", ".") }}</div>
  <div class="col-start-8 col-span-2"></div>
  <div class="col-start-9 col-end-9  border-0 text-left border-0"> R$ {{number_format(($this->getTableRecords()->sum('valor_recebido')),2, ",", ".") }}</div>

</div>

