@registration @FOSUserBundle @javascript

Feature: Register New User
  In order to use the application
  As a German brewer
  I first need to be able to register in German

  Background: This is testing the Friends of Symfony User Bundle and the translation bundle
    This is not a good example of a Behat test

  Scenario:
    Given I am on "/de/login"
    And I follow "Brauchen Sie ein Beeriously-konto?"
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
    Then I should be on "/de/register/confirmed"
    And I should see "Glückwunsch milwaukeebierbrauer, Ihr Benutzerkonto ist jetzt bestätigt."
    When I follow "Gehe zum Beeriously-Armaturenbrett >"
    Then I should be on "/de/dashboard"
    Then I should see "Armaturenbrett"
