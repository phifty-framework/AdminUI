
### Setup for Quickbox

```
  AdminUI:
    MenuStyle: quickbox
    MenuTemplate: '@AdminUI/quickbox.html'
```

### Setup for Customization

```
  AdminUI:
    # MenuTemplate: '@App/menu.html'
    BasePageTemplate: '@App/page.html'
    LoginPageTemplate: '@App/login.html'
    LoginModalTemplate: '@App/login_modal.html'
    LoginController: 'UserBundle\Controller\LoginController'
    DashboardController: 'AdminUI\Controller\BaseController'
    WebFonts: false
    Assets:
    - underscore-js
    - reactjs15
    - moment
    - jquery-cookie
    - bootstrap
    - bootstrap-material-design
    - bootstrap-daterangepicker
    - colorbox
    - font-awesome-4.3
    - highcharts-4.1
    - modal-manager
    - chosen
    - holder
    - phifty-sortable-bundle
    - backstage
    - applib
    - app
  CRUD:
    TemplateNamespace: "AppCRUD"
```

`BasePageTemplate` can be used to configure base page template:

    BasePageTemplate: "@App/page.html.twig"


To include the assets from different bundles in the templates:

    {% if Kernel.bundle('I18N') %}
        {% assets Kernel.bundle('I18N').getAssets() %}
    {% endif %}

