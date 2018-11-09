@registration @FOSUserBundle @i18n @javascript

Feature: Infrastructure Test: Register New User (Friends of Symfony User Bundle and i18n Routing Bundle Integration Test)

  Scenario:
    Given I am on "/de/login"
    And I follow "Sie haben noch kein Beeriously-konto?"
    Then I should be on "/de/register/"
    Then I should see "Registrieren"
    When I fill in the following:
      | E-Mail-Adresse      | test-user-new-german-account@beeriously.com   |
      | Benutzername        | milwaukeebierbrauer                           |
      | Passwort            | piraten2-1                                    |
      | Passwort bestätigen | piraten2-1                                    |
      | Vorname             | Shaun                                         |
      | Nachname            | Marcum                                        |
    When I select "si" from "fos_user_registration_form[massVolumePreferenceUnits]"
    When I select "plato" from "fos_user_registration_form[densityPreferenceUnits]"
    When I select "c" from "fos_user_registration_form[temperaturePreferenceUnits]"
    When I press "Registrieren"
    Then I should be on "/de/register/check-email"
    And I should see "Eine E-Mail wurde an test-user-new-german-account@beeriously.com gesendet. Sie enthält einen Link, den Sie anklicken müssen, um Ihr Benutzerkonto zu bestätigen."
