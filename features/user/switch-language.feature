@registration @i18n

Feature: Test Switch Language (i18n)
  In order use the software in the brewers native language
  As a brewer
  I need to be able use a different language

  Scenario:
    Given I am on "/"
    Then I should be on "/us/login"
    When I follow "Switch Language"
    Then I should be on "/us/choose-language"
    And I follow "Deutsch (German)"
    Then I should be on "/de/login"
