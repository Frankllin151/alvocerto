# 🐞 BUGS PENDENTES

Registro de erros e problemas encontrados durante o desenvolvimento do projeto.

---

## 🚧 **Bugs Atuais**

### 1. Modal não abre
 

---

## ✅ **Bugs Resolvidos**
- **Descrição:** Ao adicionar a query o modal não por conta do recarregamento  
- **Possível causa:** Ao carregar novamente o estado do toggle some então o modal não abre
- **Arquivo relacionado:** `resources/views/dashboard.blade.php linha 110`  
- **Status:** ⏳ Resolvido
- **Prioridade:** -sem prioridade 
- **Responsável:** Frankllin 
- **Solução:**  Salve o estado do Toggle ao carregar a query para abrir o modal, no entanto 
- me deparei com outro bug na página de visualizar decidir colocar a função de fechado do modal em página diferente por conta da lógica diferente olhe arquivo dashboard.blade.php linha: 157 arquivo visualizar.blade.php linha 43

## 💡 **Observações Gerais**
- Sempre testar no modo **local** antes de enviar para produção.  
- Revisar o console do navegador para erros JS.  
- Rodar `php artisan optimize:clear` após alterações em Blade.  

---

📅 **Última atualização:** 28/10/2025  
✍️ **Autor:** Frankllin Silva
