<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmação de Inscrição | Circuito Dunas</title>
  <style>
    body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; }
    .wrapper { width: 100%; background-color: #f4f4f4; padding: 30px 0; }
    .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; }
    .header { background-color: #1a2e4a; padding: 30px 20px; text-align: center; }
    .header h1 { color: #ffffff; margin: 0; font-size: 20px; letter-spacing: 1px; text-transform: uppercase; }
    .header p { color: #c8d8e8; margin: 6px 0 0; font-size: 13px; }
    .body { padding: 36px 32px; color: #333333; font-size: 15px; line-height: 1.7; }
    .body p { margin: 0 0 16px; }
    .info-box { background-color: #f0f5fb; border-left: 4px solid #1a2e4a; border-radius: 4px; padding: 16px 20px; margin: 24px 0; }
    .info-box table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .info-box td { padding: 4px 0; }
    .info-box td:first-child { color: #666666; width: 140px; }
    .info-box td:last-child { font-weight: bold; color: #1a2e4a; }
    .badge { display: inline-block; background-color: #2ecc71; color: #ffffff; font-size: 12px; font-weight: bold; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
    .footer { background-color: #f9f9f9; border-top: 1px solid #eeeeee; text-align: center; padding: 20px; font-size: 12px; color: #999999; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="container">

      <div class="header">
        <h1>Confirmação de Inscrição</h1>
        <p>Circuito Dunas</p>
      </div>

      <div class="body">
        <p>Olá, <strong>{{ $user->nome_completo }}</strong>!</p>

        <p>Sua inscrição no <strong>Circuito Dunas</strong> foi realizada com sucesso. Confira os detalhes abaixo:</p>

        <div class="info-box">
          <table>
            <tr>
              <td>Atleta</td>
              <td>{{ $user->nome_completo }}</td>
            </tr>
            <tr>
              <td>CPF</td>
              <td>{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf) }}</td>
            </tr>
            <tr>
              <td>Categoria</td>
              <td>{{ $registration->prf_categorys->nome ?? '—' }}</td>
            </tr>
            <tr>
              <td>Pacote</td>
              <td>{{ $registration->prf_package->nome ?? '—' }}</td>
            </tr>
            <tr>
              <td>Camiseta</td>
              <td>{{ $registration->prf_size_tshirts->size ?? '—' }}</td>
            </tr>
            @if($registration->equipe)
            <tr>
              <td>Equipe</td>
              <td>{{ $registration->equipe }}</td>
            </tr>
            @endif
            <tr>
              <td>Status</td>
              <td><span class="badge">Confirmado</span></td>
            </tr>
          </table>
        </div>

        <p>Qualquer dúvida, entre em contato com a organização do evento.</p>

        <p>Até a largada!</p>
      </div>

      <div class="footer">
        <p>Circuito Dunas &mdash; Arena das Dunas</p>
        <p>Este é um e-mail automático, por favor não responda.</p>
      </div>

    </div>
  </div>
</body>
</html>
